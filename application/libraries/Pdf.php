<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Incluimos el archivo fpdf
require_once APPPATH."/third_party/fpdf/fpdf.php";

//Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
class Pdf extends FPDF
{
    public function __construct()
    { parent::__construct(); }

    var $angle=0;
        protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

function Rotate($angle,$x=-1,$y=-1)
{
    if($x==-1)
        $x=$this->x;
    if($y==-1)
        $y=$this->y;
    if($this->angle!=0)
        $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
    {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
}

function _endpage()
{
    if($this->angle!=0)
    {
        $this->angle=0;
        $this->_out('Q');
    }
    parent::_endpage();
}

    function footer2()
    {
        $this->SetY(270);
        $this->SetCol(0);
        $this->SetFont('Helvetica','',7);
        $this->Cell(10,0,'Fecha Impresion: '.date('d-m-Y H:i:s'),0,0,'L');
        $this->Cell(0,0,' HEGAR Soluciones en Sistemas S. de R.L. 2016-'.date('Y').' www.hegarss.com       Usuario: '.$_SESSION['nombreU'],0,0,'C');
        $this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
    }

    function Footer()
    {

            $this->SetY(-5);
            $this->SetFont('Arial','I',7);
            // $this->Cell(10,0,'Fecha Impresion: '.date('d-m-Y H:i:s'),0,0,'L');
            // $this->Cell(0,0,' HEGAR Soluciones en Sistemas S. de R.L. 2016-'.date('Y').' www.hegarss.com       Usuario: '.$_SESSION['nombreU'],0,0,'C');
            // $this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
       
    }

    function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
    //Funciones
    function SetWidths($w){ $this->widths=$w;}
    function SetAligns($a){ $this->aligns=$a;}

    function Row($data,$align='C',$height1=5,$h2='2.5')
    {
        $nb=0;
       
        for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=$height1*$nb;
        $pageB=$this->CheckPageBreak($h);
       
        for($i=0;$i<count($data);$i++)
        {
         $w=$this->widths[$i];
         $a=isset($align) ? $align : 'C';
         $x=$this->GetX();
         $y=$this->GetY();

         $this->MultiCell($w,$h2,$data[$i],0,$align);
         $this->SetXY($x+$w,$y);
       }
       
    }
       function CheckPageBreak($h)
       {
           if($this->GetY()+$h>$this->PageBreakTrigger)
            {
              $this->AddPage($this->CurOrientation);
              return 1;
            }
              else return 0;
       }

       function NbLines($w,$txt)
       {
           $cw=&$this->CurrentFont['cw'];
           if($w==0)
           $w=$this->w-$this->rMargin-$this->x;
           $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
           $s=str_replace("\r",'',$txt);
           $nb=strlen($s);
           if($nb>0 and $s[$nb-1]=="\n")
               $nb--;
           $sep=-1;   $i=0;
           $j=0;      $l=0;
           $nl=1;
           while($i<$nb)
           {
               $c=$s[$i];
               if($c=="\n")
               {
                   $i++;   $sep=-1;
                   $j=$i;  $l=0;
                   $nl++;
                   continue;
               }
               if($c==' ')
                   $sep=$i;
               $l+=$cw[$c];
               if($l>$wmax)
               {
                   if($sep==-1)
                   { if($i==$j) $i++; }
                   else
                   $i=$sep+1;  $sep=-1;
                   $j=$i;      $l=0;
                   $nl++;
               }
               else
                   $i++;
           }
           return $nl;
       }

       function SetCol($col)
       {
           $this->col = $col;
           $x = 10+$col*65;
           $this->SetLeftMargin($x);
           $this->SetX($x);
       }


       function num2letras($num,$moneda, $fem = false, $dec = true) {
          $matuni[2]  = "DOS";
          $matuni[3]  = "TRES";
          $matuni[4]  = "CUATRO";
          $matuni[5]  = "CINCO";
          $matuni[6]  = "SEIS";
          $matuni[7]  = "SIETE";
          $matuni[8]  = "OCHO";
          $matuni[9]  = "NUEVE";
          $matuni[10] = "DIEZ";
          $matuni[11] = "ONCE";
          $matuni[12] = "DOCE";
          $matuni[13] = "TRECE";
          $matuni[14] = "CATORCE";
          $matuni[15] = "QUINCE";
          $matuni[16] = "DIECISEIS";
          $matuni[17] = "DIECISIETE";
          $matuni[18] = "DIECIOCHO";
          $matuni[19] = "DIECINUEVE";
          $matuni[20] = "VEINTE";
          $matunisub[2] = "DOS";
          $matunisub[3] = "TRES";
          $matunisub[4] = "CUATRO";
          $matunisub[5] = "QUIN";
          $matunisub[6] = "SEIS";
          $matunisub[7] = "SETE";
          $matunisub[8] = "OCHO";
          $matunisub[9] = "NOVE";

          $matdec[2] = "VEINT";
          $matdec[3] = "TREINTA";
          $matdec[4] = "CUARENTA";
          $matdec[5] = "CINCUENTA";
          $matdec[6] = "SESENTA";
          $matdec[7] = "SETENTA";
          $matdec[8] = "OCHENTA";
          $matdec[9] = "NOVENTA";
          $matsub[3]  = 'MILL';
          $matsub[5]  = 'BILL';
          $matsub[7]  = 'MILL';
          $matsub[9]  = 'TRILL';
          $matsub[11] = 'MILL';
          $matsub[13] = 'BILL';
          $matsub[15] = 'MILL';
          $matmil[4]  = 'MILLONES';
          $matmil[6]  = 'BILLONES';
          $matmil[7]  = 'DE BILLONES';
          $matmil[8]  = 'MILLONES DE MILLONES';
          $matmil[10] = 'TRILLONES';
          $matmil[11] = 'DE TRILLONES';
          $matmil[12] = 'MILLONES DE TRILLONES';
          $matmil[13] = 'DE TRILLONES';
          $matmil[14] = 'BILLONES DE TRILLONES';
          $matmil[15] = 'DE BILLONES DE TRILLONES';
          $matmil[16] = 'MILLONES DE BILLONES DE TRILLONES';

          //Zi hack
          $float=explode('.',$num);
          $num=$float[0];

          $num = trim((string)@$num);
          if ($num[0] == '-') {
             $neg = 'MENOS ';
             $num = substr($num, 1);
          }else
             $neg = '';
          while ($num[0] == '0') $num = substr($num, 1);
          if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
          $zeros = true;
          $punt = false;
          $ent = '';
          $fra = '';
          for ($c = 0; $c < strlen($num); $c++) {
             $n = $num[$c];
             if (! (strpos(".,'''", $n) === false)) {
                if ($punt) break;
                else{
                   $punt = true;
                   continue;
                }

             }elseif (! (strpos('0123456789', $n) === false)) {
                if ($punt) {
                   if ($n != '0') $zeros = false;
                   $fra .= $n;
                }else

                   $ent .= $n;
             }else

                break;

          }
          $ent = '     ' . $ent;
          if ($dec and $fra and ! $zeros) {
             $fin = ' coma';
             for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                   $fin .= ' CERO';
                elseif ($s == '1')
                   $fin .= $fem ? ' UNA' : ' UN';
                else
                   $fin .= ' ' . $matuni[$s];
             }
          }else
             $fin = '';
          if ((int)$ent === 0) return 'Cero ' . $fin;
          $tex = '';
          $sub = 0;
          $mils = 0;
          $neutro = false;
          while ( ($num = substr($ent, -3)) != '   ') {
             $ent = substr($ent, 0, -3);
             if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'AS';
             }else{
                $matuni[1] = $neutro ? 'UN' : 'UNO';
                $subcent = 'OS';
             }
             $t = '';
             $n2 = substr($num, 1);
             if ($n2 == '00') {
             }elseif ($n2 < 21)
                $t = ' ' . $matuni[(int)$n2];
             elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0) $t = 'I' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
             }else{
                $n3 = $num[2];
                if ($n3 != 0) $t = ' Y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
             }
             $n = $num[0];
             if ($n == 1) {
                $t = ' CIENTO' . $t;
             }elseif ($n == 5){
                $t = ' ' . $matunisub[$n] . 'IENT' . $subcent . $t;
             }elseif ($n != 0){
                $t = ' ' . $matunisub[$n] . 'CIENT' . $subcent . $t;
             }
             if ($sub == 1) {
             }elseif (! isset($matsub[$sub])) {
                if ($num == 1) {
                   $t = ' MIL';
                }elseif ($num > 1){
                   $t .= ' MIL';
                }
             }elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
             }elseif ($num > 1){
                $t .= ' ' . $matsub[$sub] . 'ONES';
             }
             if ($num == '000') $mils ++;
             elseif ($mils != 0) {
                if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
                $mils = 0;
             }
             $neutro = true;
             $tex = $t . $tex;
          }
          $tex = $neg . substr($tex, 1) . $fin;
          //Zi hack --> return ucfirst($tex);
          if($moneda=="MXN")
          {
            $moneda="M.N.";
            $pesos=" PESOS";
          }
          else
          { $pesos=" DOLARES";}
          $end_num=ucfirst($tex).$pesos.' '.$float[1].'/100 '.$moneda;
          return $end_num;
       }
       function WriteHTML($html)
       {
           // HTML parser
           $html = str_replace("\n",' ',$html);
           $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
           foreach($a as $i=>$e)
           {
               if($i%2==0)
               {
                   // Text
                   if($this->HREF)
                       $this->PutLink($this->HREF,$e);
                   else
                       $this->Write(5,$e);
               }
               else
               {
                   // Tag
                   if($e[0]=='/')
                       $this->CloseTag(strtoupper(substr($e,1)));
                   else
                   {
                       // Extract attributes
                       $a2 = explode(' ',$e);
                       $tag = strtoupper(array_shift($a2));
                       $attr = array();
                       foreach($a2 as $v)
                       {
                           if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                               $attr[strtoupper($a3[1])] = $a3[2];
                       }
                       $this->OpenTag($tag,$attr);
                   }
               }
           }
       }
   
       function OpenTag($tag, $attr)
       {
           // Opening tag
           if($tag=='B' || $tag=='I' || $tag=='U')
               $this->SetStyle($tag,true);
           if($tag=='A')
               $this->HREF = $attr['HREF'];
           if($tag=='BR')
               $this->Ln(5);
       }
   
       function CloseTag($tag)
       {
           // Closing tag
           if($tag=='B' || $tag=='I' || $tag=='U')
               $this->SetStyle($tag,false);
           if($tag=='A')
               $this->HREF = '';
       }
   
       function SetStyle($tag, $enable)
       {
           // Modify style and select corresponding font
           $this->$tag += ($enable ? 1 : -1);
           $style = '';
           foreach(array('B', 'I', 'U') as $s)
           {
               if($this->$s>0)
                   $style .= $s;
           }
           $this->SetFont('',$style);
       }
   
       function PutLink($URL, $txt)
       {
           // Put a hyperlink
           $this->SetTextColor(0,0,255);
           $this->SetStyle('U',true);
           $this->Write(5,$txt,$URL);
           $this->SetStyle('U',false);
           $this->SetTextColor(0);
       }
    }
?>
