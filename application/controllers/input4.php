if ($keyd == 0 && $key == 0) {
$vv_format = "<br />" . $key2 . "<br />";
} else {
$vv_format = "";
}
$hasilformat = $data_dum[$i] . " X " . $valued . " ";
$sum_price += $valued;
$htmlformatd[$key2][$key] .= $this->load->view($this->main . '/formatd', ['hasil' => $hasilformat, 'format' => $vv_format, 'color' => 'info'], true);