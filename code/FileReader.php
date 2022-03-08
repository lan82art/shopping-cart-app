<?php

class FileReader {
    protected $handler;
    /**
     * set initial state
     * @param string $file_input
     * @throws Exception
     */
    public function __construct(string $file_input){
        if(!($this->handler = fopen($file_input, "r")))
            throw new Exception("Cannot open the file");
    }

    /**
     * read line
     * @throws Exception
     */
    public function read_line(){
        if(!$this->handler)
            throw new Exception("Invalid file pointer");
        return fgets($this->handler);
    }

    /**
     * close file stream
     * @throws Exception
     * @return boolean
     */
    public function close_stream(): bool
    {
        if(!$this->handler)
            throw new Exception("Invalid file pointer");
        return fclose($this->handler);
    }
}