<?php
Yii::import('zii.widgets.grid.CGridColumn'); 
class TotalColumn extends CGridColumn {
    private $_total = 0;
    private $_attr  = null;
 
    public function getTotal()
    {
        $this->_total;
    }
    public function setTotal($value)
    {
        $this->_total = $value;
    }
 
    public function getAttribute()
    {
        return $this->_attr;
    }
    public function setAttribute($value)
    {
        $this->_attr = $value;
    }
 
    public function renderDataCellContent($row, $data) {
	    if(is_array($data)) $val=$data[$this->attribute];
		else $val=$data->{$this->attribute};
        $this->_total += $val;
        if(is_float($val)) echo number_format($val,2);
        else echo number_format($val);
    }
    
    protected function renderFooterCellContent()
    {
        if(is_float($this->_total)) echo number_format($this->_total,2);
        else echo number_format($this->_total);
        //echo $this->_total;
    }
}

?>