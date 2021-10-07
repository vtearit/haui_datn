<?php

// Mở composer.json
// Thêm vào trong "autoload" chuỗi sau
// "files": [
//     "app/Helpers/Helper.php"
// ],         "app/function/function.php"
// ]

// Chạy cmd : composer  dumpautoload
use App\Models\GroupProduct;
use App\Models\Product;

function slug($str,$strSymbol='-',$case=MB_CASE_LOWER){// MB_CASE_UPPER / MB_CASE_TITLE / MB_CASE_LOWER
	$str=trim($str);
	if ($str=="") return "";
	$str =str_replace('"','',$str);
	$str =str_replace("'",'',$str);
	$str = stripUnicode($str);
	$str = mb_convert_case($str,$case,'utf-8');
	$str = preg_replace('/[\W|_]+/',$strSymbol,$str);
	return $str;
}

function stripUnicode($str){
	if(!$str) return '';
	//$str = str_replace($a, $b, $str);
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|å|ä|æ|ā|ą|ǻ|ǎ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|Å|Ä|Æ|Ā|Ą|Ǻ|Ǎ',
		'ae'=>'ǽ',
		'AE'=>'Ǽ',
		'c'=>'ć|ç|ĉ|ċ|č',
		'C'=>'Ć|Ĉ|Ĉ|Ċ|Č',
		'd'=>'đ|ď',
		'D'=>'Đ|Ď',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|ë|ē|ĕ|ę|ė',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Ë|Ē|Ĕ|Ę|Ė',
		'f'=>'ƒ',
		'F'=>'',
		'g'=>'ĝ|ğ|ġ|ģ',
		'G'=>'Ĝ|Ğ|Ġ|Ģ',
		'h'=>'ĥ|ħ',
		'H'=>'Ĥ|Ħ',
		'i'=>'í|ì|ỉ|ĩ|ị|î|ï|ī|ĭ|ǐ|į|ı',	  
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị|Î|Ï|Ī|Ĭ|Ǐ|Į|İ',
		'ij'=>'ĳ',	  
		'IJ'=>'Ĳ',
		'j'=>'ĵ',	  
		'J'=>'Ĵ',
		'k'=>'ķ',	  
		'K'=>'Ķ',
		'l'=>'ĺ|ļ|ľ|ŀ|ł',	  
		'L'=>'Ĺ|Ļ|Ľ|Ŀ|Ł',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ö|ø|ǿ|ǒ|ō|ŏ|ő',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ö|Ø|Ǿ|Ǒ|Ō|Ŏ|Ő',
		'Oe'=>'œ',
		'OE'=>'Œ',
		'n'=>'ñ|ń|ņ|ň|ŉ',
		'N'=>'Ñ|Ń|Ņ|Ň',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|û|ū|ŭ|ü|ů|ű|ų|ǔ|ǖ|ǘ|ǚ|ǜ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Û|Ū|Ŭ|Ü|Ů|Ű|Ų|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ',
		's'=>'ŕ|ŗ|ř',
		'R'=>'Ŕ|Ŗ|Ř',
		's'=>'ß|ſ|ś|ŝ|ş|š',
		'S'=>'Ś|Ŝ|Ş|Š',
		't'=>'ţ|ť|ŧ',
		'T'=>'Ţ|Ť|Ŧ',
		'w'=>'ŵ',
		'W'=>'Ŵ',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ|ÿ|ŷ',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ|Ÿ|Ŷ',
		'z'=>'ź|ż|ž',
		'Z'=>'Ź|Ż|Ž'
	);
	foreach($unicode as $khongdau=>$codau) {
		$arr=explode("|",$codau);
		$str = str_replace($arr,$khongdau,$str);
	}
	return $str;
}
function isKM($bd,$kt){
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$now=date('Y-m-d');
	$bd=strtotime($bd);
	$kt=strtotime($kt);
	$now=strtotime($now);
	if($bd<=$now&&$kt>=$now)
	{
		return true;
		
	}
	 else
	{
		return false;
	}
}

function minPrice($gp_id)
{
    $first=Product::where("group_product_id",$gp_id)->first();
    $product=Product::where("group_product_id",$gp_id)->get();
    if(count($product)>0)
    {
        $min=$first->product_price;
        foreach($product as $p)
        {
            if(isKM($p->bdkm,$p->ktkm))
            {
                if($p->product_price_km<$min)
                {
                    $min=$p->product_price_km;
                }
            }
            else
            {
                if($p->product_price<$min)
                {
                    $min=$p->product_price;
                }
            }
        }
        return $min;
    }
	
}
function discount($gp)
{
    $product=$gp->product;
	$percent=0;
	$product_price=1;
	$product_price_km=1;
	foreach($product as $p)
	{
		if(isKM($p->bdkm,$p->ktkm))
		{
			$product_price=$p->product_price;
			$product_price_km=$p->product_price_km;
		}
	}
	$percent=(round($product_price_km/$product_price*100))-100;
	return $percent;
}
function actionProduct($gp)
{
	$status=0;
    $product=$gp->product;
	$dau_thang=Now('Asia/Ho_Chi_Minh')->startOfMonth();
    $cuoi_thang=Now('Asia/Ho_Chi_Minh')->endOfMonth();
	$now=date('Y-m-d');
	$dau_thang=strtotime($dau_thang);
	$cuoi_thang=strtotime($cuoi_thang);
	foreach($product as $p)
	{
		$date=strtotime($p->created_at);
		if($dau_thang<$date&&$date<$cuoi_thang)
		{
			$status=1;
		}
		else if($p->product_status==2)
		{
			$status=2;
		}
	}
	return $status;
}
