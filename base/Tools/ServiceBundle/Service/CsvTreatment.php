<?php
namespace Id2i\Tools\ServiceBundle\Service;

class CsvTreatment {
    private $titles = array();
    private $lines = array();
    private $comaSeparator = ";";
    private $textEnclosure = '';
    private $buffer = "";

    public function addTitlesHeader($titles)
    {
        $this->titles = $titles;
    }

    public function addDatas2Line($datas)
    {
        $this->lines[] = $datas;
    }

    public function addObject2Line($object)
    {
        $datas = array();
        foreach($object as $propriety){
            $datas[] = $this->textEnclosure.$propriety.$this->textEnclosure;
        }
        $this->lines[] = $datas;
    }

    public function saveFile($pathFileName)
    {
        $this->removeFile($pathFileName);
        $file = fopen($pathFileName,"w");

        if(!empty($this->titles)){
            fputcsv($file,$this->titles, $this->comaSeparator);
        }

        foreach ($this->lines as $line){
            fputcsv($file,$line, $this->comaSeparator);
        }
        fclose($file);
    }

    public function getBuffer(){
        if(empty($this->buffer)){
            $this->setBuffer();
        }
        return $this->buffer;
    }

    public function clearBuffer(){
        $this->titles = array();
        $this->lines = array();
        $this->buffer = "";
    }

    public function setDatasFromFile($filePath, $parseHeader=false, $columnDelimiter = ";", $enclosure = '"', $lineDelimiter = "\r\n")
    {
        $this->clearBuffer();

        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (FALSE !== ($line = fgetcsv($handle, 2048, $columnDelimiter, $enclosure))) {

                if(empty($line) || count($line) <= 1){//ignore les lignes vides
                    continue;
                }

                $this->lines[] = $line;
            }
            fclose($handle);
        }

        if(TRUE === $parseHeader){//extrait l'entete
            $this->titles = array_shift($this->lines);
        }
    }

    public function getDatasFromFile($filePath, $parseHeader=false, $columnDelimiter = ";", $enclosure = '"', $lineDelimiter = "\r\n")
    {
        $this->setDatasFromFile($filePath, $parseHeader, $columnDelimiter, $enclosure, $lineDelimiter);
        return $this->lines;
    }

    public function getTitles(){
        return $this->titles;
    }

    public function getLines(){
        return $this->lines;
    }

    public function getFormatObjectLines(array $proprietiesName, $ignoreBlankLine = true){
        $datas = array();
        foreach($this->lines as $line){

            if(true === $ignoreBlankLine && count($line) == 1){
                continue;
            }

            $datas[] = $this->format2objectLine($line, $proprietiesName);
        }
        return $datas;
    }

    private function removeFile($pathFileName){
        if(file_exists($pathFileName)){
            unlink($pathFileName);
        }
    }

    private function setBuffer(){
        if(!empty($this->titles)){
            $this->buffer = implode($this->comaSeparator, $this->titles) . "\r\n";
        }

        foreach ($this->lines as $line){
            $this->buffer .= implode($this->comaSeparator, $line)."\r\n";
        }
    }

    private function format2objectLine($datas, $proprietiesName){
        if(count($datas) !== count($proprietiesName)){

            echo count($datas) ."!==". count($proprietiesName);
            exit();

            throw new Exception("Le nombre de propriété doit être égale au nombre de colonne dans la ligne du CSV");
        }

        $object = new stdClass();

        foreach($datas as $i => $data){
            $object->$proprietiesName[$i] = $data;
        }

        return $object;
    }
}