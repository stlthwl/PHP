<?php

namespace RegistryService\Infrastructure\Extension\RosStroyZakaz\Application\Command;


use DateTime;
use RegistryService\Domain\Service\RandomGeneratorInterface;
use RegistryService\Infrastructure\Extension\RosStroyZakaz\Domain\Model\Entity\File;
use RegistryService\Infrastructure\Extension\RosStroyZakaz\Domain\Repository\Entity\Command\FileCommandRepositoryInterface;
use RegistryService\Infrastructure\Extension\RosStroyZakaz\Domain\Repository\Entity\Command\MaintenanceRequestCommandRepositoryInterface;
use RegistryService\Domain\Registry\Service\CommandExecutorServiceInterface;
use Doctrine\DBAL\{
    Connection
};

class FillXmlFieldInMaintenanceRequestCommand
{
    private $maintenanceRequestCommandRepository;
    private $fileCommandRepository;
    private $connection;
    private $randomGenerator;

    //алиас для фалового поля
    private const XML_FILE = 'xml_file';
    //алиас для поля с типом XML
    private const XML_STRUCTURE = 'xml_structure';
    //расширение для записываемого файла
    private const FILE_EXTENSION = 'xml';

    public function __construct(
        MaintenanceRequestCommandRepositoryInterface $maintenanceRequestCommandRepository,
        FileCommandRepositoryInterface $fileCommandRepository,
        Connection $connection,
        CommandExecutorServiceInterface $commandExecutorService,
        RandomGeneratorInterface $randomGenerator
    )
    {
        $this->maintenanceRequestCommandRepository = $maintenanceRequestCommandRepository;
        $this->fileCommandRepository = $fileCommandRepository;
        $this->connection = $connection;
        $this->commandExecutorService = $commandExecutorService;
        $this->randomGenerator = $randomGenerator;
    }

    //функция поиска значения по ключу в массиве
    function get_value_by_key($array,$key)
    {
        foreach($array as $k=>$each) {
            if($k==$key) {
                return $each;
            }
        }
    }

    public function execute(int $recordId, int $objectId)
    {
        $getAttrId = $this->connection->createQueryBuilder();
        $getAttrId
            ->select("id", "alias")
            ->from("object_editor.entities")
            ->where($getAttrId->expr()->eq("parent_id", $objectId));
        $arr = $getAttrId->execute()->fetchAllAssociative();

        $xmlField = array_filter($arr, function($ar) {
            return ($ar['alias'] == self::XML_STRUCTURE);
        });
        $resArrXmlField = array_shift($xmlField);
        //id поля xml
        $attrXmlFieldId = $this->get_value_by_key($resArrXmlField, "id");

        $xmlFile = array_filter($arr, function($ar) {
            return ($ar['alias'] == self::XML_FILE);
        });
        $resArrXmlFile = array_shift($xmlFile);
        //id поля с файлом
        $attrXmlFileId = $this->get_value_by_key($resArrXmlFile, "id");
        var_dump($attrXmlFieldId);
        var_dump($attrXmlFileId);


        $directory = "CreateXmlFileCommand";
        $path = sprintf("%s/%s", getenv("FILES_STORAGE"), $directory);

        var_dump($directory);
        var_dump($path);

        if (!realpath($path)) {
            mkdir($path);
        }
        var_dump($_FILES);

        $filename = $this->randomGenerator->generateGuid();

        var_dump($filename);

        $getXmlStructure = $this->connection->createQueryBuilder();
        $getXmlStructure
            ->select(sprintf("attr_%s_", $attrXmlFieldId))
            ->from(sprintf("registry.object_%s_", $objectId))
            ->where($getXmlStructure->expr()->eq("id", $recordId));

        $xml = $getXmlStructure->execute()->fetchAllAssociative();
        $xmldata = [];
        foreach ($xml as $data) {
            $xmldata[$data[sprintf("attr_%s_", $attrXmlFieldId)]] = $data[sprintf("attr_%s_", $attrXmlFieldId)];
        }

        $xmlString = end($xmldata);
        var_dump($xmlString);

        file_put_contents(sprintf("%s/%s.%s", $path, $filename, self::FILE_EXTENSION), $xmlString);

        $file = new File();
        $file
            ->setGuid($filename)
            ->setName('file3')
            ->setExtension(self::FILE_EXTENSION)
            ->setChecksum("test")
            ->setCreateDate(new DateTime("now"))
            ->setDirectory($directory);

        $this->fileCommandRepository->insert($file);
        $this->fileCommandRepository->insertLink(
            $objectId,
            $attrXmlFileId,
            $recordId,
            $file->getId()
        );
    }
}