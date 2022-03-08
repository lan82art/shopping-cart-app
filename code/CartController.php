<?php
require 'FileReader.php';

class CartController
{
    protected $cart_total = 0;
    protected $file_reader;
    protected $amount;
    protected $price;
    protected $currency;
    private $EUR_to_USD = 1.14;
    private $EUR_to_GBP = 0.88;

    /**
     * set initial state
     * @param string $file_input
     * @throws Exception
     */
    public function __construct(string $file_input)
    {
        $this->file_reader = new FileReader($file_input);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        while ($row = $this->file_reader->read_line()) {
            if ($this->parse_row($row)) {
                $this->cart_action();
            }
        }
        $this->file_reader->close_stream();
    }

    /**
     * parse data from row
     * @param string $row
     * @return boolean
     */
    private function parse_row(string $row): bool
    {
        $array = explode(';', $row);
        if (count($array) !== 5) {
            echo "Wrong row\n";
            return false;
        }

        $this->amount = (int)$array[2];
        $this->price = (float)$array[3];
        $this->currency = trim((string)$array[4]);
        if ($this->currency !== 'EUR' && $this->currency !== 'USD' && $this->currency !== 'GBP') {
            echo "Wrong currency\n";
            return false;
        }
        return true;
    }

    /**
     * do action cart
     */
    private function cart_action()
    {
        if ($this->currency !== 'EUR') {
            $this->convert_currency();
        }
        $this->cart_total += $this->price * $this->amount;
        echo $this->cart_total . "\n";
    }

    /**
     * convert currency to EUR
     */
    private function convert_currency()
    {
        if ($this->currency == 'USD') {
            $this->price = round($this->price / $this->EUR_to_USD, 2);
        } elseif ($this->currency == 'GBP') {
            $this->price = round($this->price / $this->EUR_to_GBP, 2);
        }
    }
}