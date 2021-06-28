<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class kesimpulan extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function index()
    {
        $column_value = ['2d', '3d', '4d'];
        if ($this->omset->get(['date' => date('Y-m-d'), 'status' => 0])) {
            foreach ($column_value as $kcol => $kval) {
                $column_name = ['NO', 'ANGKA ' . strtoupper($kval), 'JUMLAH'];
                $this->data['headTable' . $kval] = "<thead>";
                $this->data['headTable' . $kval] .= "<tr>";
                foreach ($column_name as $key => $value) {
                    $this->data['headTable' . $kval] .= "<th>" . $value . "</th>";
                }
                $this->data['headTable' . $kval] .= "</tr>";
                $this->data['headTable' . $kval] .= "</thead>";
                $this->data['bodyTable' . $kval] = "<tbody>";
                $no = 1;
                $count[$kval] = 0;
                foreach ($this->master->getsWhereIn(['format' => strtoupper($kval), 'date(create_date)' => date('Y-m-d')], 'angka') as $keyv => $valuev) {
                    $count[$kval] += $valuev->count;
                    $this->data['bodyTable' . $kval] .= "<tr>";
                    $this->data['bodyTable' . $kval] .= "<td class='table-info' style='width:5px;'>" . $no++ . "</td>";
                    $this->data['bodyTable' . $kval] .= "<td>" . $valuev->angka . "</td>";
                    $this->data['bodyTable' . $kval] .= "<td style='width:5px;'>" . $valuev->count . "</td>";
                    $this->data['bodyTable' . $kval] .= "</tr>";
                }
                if (!empty($this->master->getsWhereIn(['format' => 'BBSET', 'date(create_date)' => date('Y-m-d')], 'angka'))) {
                    foreach ($this->master->getsWhereIn(['format' => 'BBSET', 'date(create_date)' => date('Y-m-d')], 'angka') as $keyv => $valuev) {
                        $kval = strlen($valuev->angka) . 'd';
                        !isset($count[$kval]) ? $count[$kval] = 0 : $count[$kval] += $valuev->count;
                        if (!isset($this->data['bodyTable' . $kval])) $this->data['bodyTable' . $kval] = "";
                        $this->data['bodyTable' . $kval] .= "<tr>";
                        $this->data['bodyTable' . $kval] .= "<td class='table-info' style='width:5px;'>" . $no++ . "</td>";
                        $this->data['bodyTable' . $kval] .= "<td>" . $valuev->angka . "</td>";
                        $this->data['bodyTable' . $kval] .= "<td style='width:5px;'>" . $valuev->count . "</td>";
                        $this->data['bodyTable' . $kval] .= "</tr>";
                    }
                }

                $this->data['bodyTable' . $kval] .= "</tbody>";
                $this->data['bodyTable' . $kval] .= "<tfoot>";
                $this->data['bodyTable' . $kval] .= "<tr>";
                $this->data['bodyTable' . $kval] .= "<th colspan='2'>JUMLAH</th>";
                $this->data['bodyTable' . $kval] .= "<th>" . $count[$kval] . "</th>";
                $this->data['bodyTable' . $kval] .= "</tr>";
                $this->data['bodyTable' . $kval] .= "</tfoot>";
            }
        } else {
            foreach ($column_value as $kcol => $kval) {
                $this->data['headTable' . $kval] = "";
                $this->data['bodyTable' . $kval] = "";
            }
        }
        parent::index();
    }

    public function download2d()
    {
        $notepad = "";
        if (!empty($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]))) {
            $dum_val = "";
            $sum = 0;
            foreach ($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]) as $kmaster => $val_master) {
                if (!empty($this->master->getsSum(['id' => $val_master->id, 'format' => '2D'], 'angka'))) {
                    foreach ($this->master->getsSum(['id' => $val_master->id, 'format' => '2D'], 'angka') as $keyv => $valuev) {
                        $sum += $valuev->hasil;
                        $dum_val .= $valuev->angka . "x" . $valuev->hasil . ". ";
                    }
                }
            }
            $notepad .= "Tanggal: " . $this->omset->gets(['date' => date('Y-m-d'), 'status' => 0])[0]->date . " | OK 2A = " . $sum;
            $notepad .= "\r\n";
            $notepad .= $dum_val;
            $handle = fopen("laporan/2D/2D - " . date('Y-m-d') . ".txt", "w");
            fwrite($handle, $notepad);
            fclose($handle);
        }
    }
    public function download3d()
    {
        $notepad = "";
        if (!empty($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]))) {
            $dum_val = "";
            $sum = 0;
            foreach ($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]) as $kmaster => $val_master) {
                if (!empty($this->master->getsSum(['id' => $val_master->id, 'format' => '3D'], 'angka'))) {
                    foreach ($this->master->getsSum(['id' => $val_master->id, 'format' => '3D'], 'angka') as $keyv => $valuev) {
                        $sum += $valuev->hasil;
                        $dum_val .= $valuev->angka . "x" . $valuev->hasil . ". ";
                    }
                }
            }
            $notepad .= "Tanggal: " . $this->omset->gets(['date' => date('Y-m-d'), 'status' => 0])[0]->date . " | OK 3A = " . $sum;
            $notepad .= "\r\n";
            $notepad .= $dum_val;
            $handle = fopen("laporan/3D/3D - " . date('Y-m-d') . ".txt", "w");
            fwrite($handle, $notepad);
            fclose($handle);
        }
    }
    public function download4d()
    {
        $notepad = "";
        if (!empty($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]))) {
            $dum_val = "";
            $sum = 0;
            foreach ($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]) as $kmaster => $val_master) {
                if (!empty($this->master->getsSum(['id' => $val_master->id, 'format' => '4D'], 'angka'))) {
                    foreach ($this->master->getsSum(['id' => $val_master->id, 'format' => '4D'], 'angka') as $keyv => $valuev) {
                        $sum += $valuev->hasil;
                        $dum_val .= $valuev->angka . "x" . $valuev->hasil . ". ";
                    }
                }
            }
            $notepad .= "Tanggal: " . $this->omset->gets(['date' => date('Y-m-d'), 'status' => 0])[0]->date . " | OK 4A = " . $sum;
            $notepad .= "\r\n";
            $notepad .= "\r\n";
            $notepad .= $dum_val;
            $handle = fopen("laporan/4D/4D - " . date('Y-m-d') . ".txt", "w");
            fwrite($handle, $notepad);
            fclose($handle);
        }
    }

    public function downloadcolok()
    {
        $notepad = "";
        if (!empty($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]))) {
            $sum = 0;
            foreach ($this->omset->gets(['date' => date('Y-m-d'), 'status' => 0]) as $kmaster => $val_master) {
                if (!empty($this->master->getsFormatSum(['id' => $val_master->id], 'angka', "", ['CB', 'CP', 'CN']))) {
                    foreach ($this->master->getsFormatSum(['id' => $val_master->id], 'angka', [0 => 'format', 1 => 'ASC'], ['CB', 'CP', 'CN']) as $keyv => $valuev) {
                        $sum += $valuev->hasil;
                        !isset($sumf[$valuev->format]) ? $sumf[$valuev->format] = $valuev->hasil : $sumf[$valuev->format] += $valuev->hasil;
                        if (empty($dum_val[$valuev->format])) $dum_val[$valuev->format] = "";
                        $dum_val[$valuev->format] .= $valuev->format . $valuev->angka . "x" . $valuev->hasil . ". ";
                    }
                }
            }
            $notepad .= "Tanggal: " . $this->omset->gets(['date' => date('Y-m-d'), 'status' => 0])[0]->date . " | Total Colok = " . $sum;
            $notepad .= "\r\n";
            foreach ($dum_val as $key => $value) {
                $notepad .= "\r\n";
                $notepad .= $key . " = " . $sumf[$key];
                $notepad .= "\r\n";
                $notepad .= $value;
                $notepad .= "\r\n";
            }
            $handle = fopen("laporan/colok/COLOK - " . date('Y-m-d') . ".txt", "w");
            fwrite($handle, $notepad);
            fclose($handle);
        }
    }
} //End
