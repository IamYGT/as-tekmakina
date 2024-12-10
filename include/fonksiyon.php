<?php
require_once(__DIR__ . '/error_handler.php');
include_once("class.upload.php");
include_once("Mobile_Detect.php");

	@session_start();
	@ob_start();  

	function cURL($url){ 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$data = curl_exec($ch);
		curl_close($ch); 
		return $data;
	}

	function integer($str) {
		$str = CleanGet($str);
		//$n = (int)$str;
		$n = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		return $n;
	}
	function KelimeKisalt($kelime, $str = 10){
		if (strlen($kelime) > $str){
		if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
		else $kelime = substr($kelime, 0, $str).'..';
		}
		  return $kelime;
	}
	function CleanGet($data) {
		$data = strip_tags($data);
		$data = htmlspecialchars($data);
		$data = addslashes($data);
		// Güvenlik
		$ara = array("union","select","version","schema","concat","conttable","where","tables","../","embed","onmouse","background","object","script","iframe", "javascript", "");
		$data = str_replace($ara,"",$data);
		return $data;
	}
	  
		foreach($_POST AS $key => $value) {
			${$key} = (is_array($value) ? $value : addslashes(trim($value)));
		}

		foreach($_GET AS $key => $value) {
			${$key} = (is_array($value) ? $value : addslashes(trim($value)));
		}	

	function go($par, $time = 0){
		if ($time == 0){
			header("Location: {$par}");
		}else{
			header("Refresh: {$time}; url={$par}");
			}
	}
	function session_olustur($par) {
		foreach ($par as $anahtar => $deger){
			$_SESSION[$anahtar] = $deger;
			}
	}
	function session($par) {
		if ($_SESSION[$par]){
			return $_SESSION[$par];
		}else{
			return false;
			}
	}
	function GetTableValue($column, $table, $where) {
		try {
			$db = checkDB();
			$q = $db->query("SELECT $column FROM $table $where");
			if ($q) {
				$row = $q->fetch(PDO::FETCH_ASSOC);
				return $row ? stripslashes($row[$column]) : null;
			}
			return null;
		} catch (Exception $e) {
			error_log("GetTableValue hatası: " . $e->getMessage());
			return null;
		}
	}
	function Seo_Link_Cevir($str, $options = array()){
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		 $defaults = array(
			 'delimiter' => '-',
			 'limit' => null,
			 'lowercase' => true,
			 'replacements' => array(),
			 'transliterate' => true
		 );
		 $options = array_merge($defaults, $options);
		 $char_map = array(
			 // Latin
			 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			 'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			 'ß' => 'ss',
			 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			 'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			 'ÿ' => 'y',
			 // Latin symbols
			 '©' => '(c)',
			 // Greek
			 'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			 'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			 'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			 'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			 'Ϋ' => 'Y',
			 'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			 'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			 'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			 'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			 'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
			 // Turkish
			 'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			 'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
			 // Russian
			 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', '��������' => 'Zh',
			 'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			 'Я' => 'Ya',
			 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			 'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			 'я' => 'ya',
			 // Ukrainian
			 'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			 'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
			 // Czech
			 'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			 'Ž' => 'Z',
			 'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			 'ž' => 'z',
			 // Polish
			 'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			 'Ż' => 'Z',
			 'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			 'ż' => 'z',
			 // Latvian
			 'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			 'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			 'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			 'š' => 's', 'ū' => 'u', 'ž' => 'z'
		 );
		 $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		 if ($options['transliterate']) {
			 $str = str_replace(array_keys($char_map), $char_map, $str);
		 }
		 $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		 $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		 $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		 $str = trim($str, $options['delimiter']);
		 return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	 }
  
	$catseo = 0; 
	function getCategories($parent_id = 0, $menuid = 'main-menu', $class = 'top-menu') {
		try {
			$db = checkDB();
			$catseo = isset($_GET['catname']);
			$subcat = false;
			$attr = (!$parent_id) ? ' class="' . $class . '" id="' . $menuid . '"' : ' class="dropdown-menu"';
			$attr2 = (!$parent_id) ? ' class="dropdown"' : ' class="dropdown-submenu"';
			$attr3 = (!$parent_id) ? ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"' : null;
			
			$query = $db->query("SELECT * FROM kategoriler WHERE kategori_durum = 1 AND kategori_tipi = 1 AND dil_id = 'tr' ORDER BY altkategori_id");
			if ($query) {
				foreach ($query as $row) {
					if ($row['altkategori_id'] == $parent_id) {
						if ($subcat === false) {
							$subcat = true;
							echo "<ul" . $attr . ">\n";
						}
						$active = ($row['kategori_seo'] == $catseo) ? " class=\"active\"" : "";
						$url = '/kategori/' . $row['kategori_seo'];
						
						$link = '<a href="'.$url.'"' . $active . ' '.$attr3.'>' . $row['kategori_baslik'] . '</a>';
						echo '<li' . $attr2 . '>';
						echo $link;
						getCategories($row["kategori_ust_id"]);
						echo "</li>\n";
					}
				}
				if ($subcat === true) {
					echo "</ul>\n";
				}
			}
		} catch (Exception $e) {
			error_log("getCategories hatası: " . $e->getMessage());
		}
	}
	function CategoryOption($id = 0, $string = 0, $altkategori_id) {
		try {
			$db = checkDB();
			$list = $db->query("SELECT * FROM kategoriler WHERE altkategori_id = {$id} AND kategori_tipi = 1 AND dil_id = 'tr'");
			if ($list && $list->rowCount()) {
				foreach($list as $row) {
					echo '<option ';
					echo $row["kategori_ust_id"] == $altkategori_id ? ' selected ' : null;
					echo 'value="'.$row["kategori_ust_id"].'">'.str_repeat('-', $string).$row["kategori_baslik"].'</option>';
					CategoryOption($row["kategori_ust_id"], $string + 2, $altkategori_id);
				}
			}
		} catch (Exception $e) {
			error_log("CategoryOption hatası: " . $e->getMessage());
			return false;
		}
	}
	
	function CategoryList($id = 0, $string = 0, $altkategori_id) {
		try {
			$db = checkDB();
			$list = $db->query("SELECT * FROM kategoriler WHERE altkategori_id = {$id} AND kategori_tipi = 1 AND dil_id = 'tr'");
			if ($list && $list->rowCount()) {
				foreach($list as $row) {
					echo '
						<tr role="row" class="even">
							<td>'.str_repeat('-', $string).$row["kategori_baslik"].'</td>
							<td>';
					if($row["kategori_durum"]=="1") {
						echo '<span class="badge badge-rounded badge-secondary">Aktif</span>';
					} else {
						echo '<span class="badge badge-rounded badge-danger">Pasif</span>';
					}
					echo '</td>
							<td class="sorting_1">
								<div class="d-flex">
									<a class="contact-icon mr-3" href="'.AREA.'?do=edit&id='.$row["kategori_ust_id"].'"><i class="fas fa-edit" aria-hidden="true"></i></a>
									<a class="contact-icon" href="'.AREA.'?do=delete&id='.$row["kategori_ust_id"].'"><i class="fas fa-trash-alt"></i></a>
								</div>
							</td>
						</tr>';
					CategoryList($row["kategori_ust_id"], $string + 2, $altkategori_id);
				}
			}
		} catch (Exception $e) {
			error_log("CategoryList hatası: " . $e->getMessage());
			return false;
		}
	} 
	
	 

	function KacDakikaOldu($zaman){
		$zaman =  strtotime($zaman);
		$zaman_farki = time() - $zaman;
		$saniye = $zaman_farki;
		$dakika = round($zaman_farki/60);
		$saat = round($zaman_farki/3600);
		$gun = round($zaman_farki/86400);
		$hafta = round($zaman_farki/604800);
		$ay = round($zaman_farki/2419200);
		$yil = round($zaman_farki/29030400);
		if( $saniye < 60 ){
			if ($saniye == 0){
				return "az önce";
			} else {
				return $saniye .' saniye önce';
			}
		} else if ( $dakika < 60 ){
			return $dakika .' dakika önce';
		} else if ( $saat < 24 ){
			return $saat.' saat önce';
		} else if ( $gun < 7 ){
			return $gun .' gün önce';
		} else if ( $hafta < 4 ){
			return $hafta.' hafta önce';
		} else if ( $ay < 12 ){
			return $ay .' ay önce';
		} else {
			return $yil.' yıl önce';
		}
	}

	function counter() {
		try {
			$db = checkDB();
			$ziyaretci_ip = $_SERVER['REMOTE_ADDR'];
			$detect = new Mobile_Detect;
			
			$ziyaretci_cihaz = $detect->isMobile() ? 'mobile' : 
							   ($detect->isTablet() ? 'tablet' : 'desktop');
			
			$guest_check = $db->prepare("SELECT * FROM ziyaretciler WHERE ziyaretci_ip = ? AND ziyaretci_cihaz = ?");
			$guest_check->execute([$ziyaretci_ip, $ziyaretci_cihaz]);
			
			if ($guest_check->rowCount() > 0) {
				$guest_id = $guest_check->fetch(PDO::FETCH_ASSOC);
				$update_query = $db->prepare("UPDATE ziyaretciler SET ziyaretci_sayac = ziyaretci_sayac + 1 WHERE ziyaretci_id = ?");
				$update_query->execute([$guest_id["ziyaretci_id"]]);
			} else {
				$ziyaretci_tarayici = $_SERVER['HTTP_USER_AGENT'];
				$ziyaretci_dil = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				
				$insert_query = $db->prepare("INSERT INTO ziyaretciler SET
					ziyaretci_ip = ?,  
					ziyaretci_cihaz = ?,   
					ziyaretci_tarayici = ?,   
					ziyaretci_dil = ?");
				$insert_query->execute([$ziyaretci_ip, $ziyaretci_cihaz, $ziyaretci_tarayici, $ziyaretci_dil]);
			}
		} catch (Exception $e) {
			error_log("Counter hatası: " . $e->getMessage());
		}
	}

	class Bilgilendirme {
		public static function Basarili($str) {
			return $str;

		} 
		public static function Bilgi($str) {
			return $str;

		} 
		public static function Hata($str) {
			return $str;
		} 
		public static function Uyari($str) {
			return $str;
		}
	}
	class Uyari {
		
		public static function Basarili($str) {
			return '
			<div class="alert alert-success"> 
				'.$str.'
			</div>';
		}
		public static function Tehlike($str) {
			return '
			<div class="alert alert-warning"> 
				'.$str.'
			</div>';
		}
		public static function Hata($str) {
			return '
			<div class="alert alert-danger"> 
				'.$str.'
			</div>';
		}
		public static function Bilgi($str) {
			return '
			<div class="alert alert-info">
				'.$str.'
			</div>';
		}
	}
	function EscapeData($data) { 
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return trim($data);
	}
	function Escape($data) {  
			$data = strip_tags($data);  
		return $data;
	}
	function LANG($anahtar, $dil_kodu = null) {
		try {
			global $db;
			if (!$dil_kodu) {
				$dil_kodu = getCurrentDil();
			}
			
			// Debug için
			error_log("LANG function called with key: " . $anahtar . " and language: " . $dil_kodu);
			
			if ($db === null) {
				error_log("Database connection is null");
				return $anahtar;
			}
			
			$query = $db->prepare("SELECT deger FROM dil_kelimeler WHERE anahtar = ? AND kod = ? LIMIT 1");
			$query->execute([$anahtar, $dil_kodu]);
			$result = $query->fetch(PDO::FETCH_ASSOC);
			
			// Debug için
			if (!$result) {
				error_log("Translation not found for key: " . $anahtar . " in language: " . $dil_kodu);
			}
			
			return $result ? $result["deger"] : $anahtar;
		} catch (Exception $e) {
			error_log("LANG hatası: " . $e->getMessage());
			return $anahtar;
		}
	}

	$cookie_adi = "LANG_COOKIE"; 
	$varsayilan_dil_q = $db->query("select * from dil where dil_varsayilan = '1'")->fetch(PDO::FETCH_ASSOC);
	$varsayilan_dil = $varsayilan_dil_q["dil_kod"];
	$varsayilanDil = $varsayilan_dil_q["dil_kod"];
	$webSettings = array();
	$php_dosya_adi = basename($_SERVER["SCRIPT_FILENAME"]); 
	$site_klasor = str_replace("/".$php_dosya_adi."","",$_SERVER["SCRIPT_NAME"]);
	$webSettings["domain_ek_klasor"] = $site_klasor;
	 
	if (isset($_GET["lang"])) {
		setcookie($cookie_adi, $_GET["lang"], time()+ (60*60*24*30));
	}

	if (isset($_GET["lang"])) {
		if ($varsayilanDil == $_GET["lang"]) {
			$site_suanki_domain = "";
		}else{
			$site_suanki_domain = $webSettings["domain"].$webSettings["domain_ek_klasor"]."/".$_GET["lang"]."/";
		}
	}else{
		$site_suanki_domain = "";
	} 
	 

	@$KullaniciID = $_SESSION["uye_id"]; 
	$members_info = $db->query("SELECT * FROM uyeler WHERE uye_id='$KullaniciID' ")->fetch(PDO::FETCH_ASSOC);	   
	$language_info = $db->query("SELECT * FROM dil WHERE dil_varsayilan = 1 ")->fetch(PDO::FETCH_ASSOC);
	define('LANGUAGE_DEFAULT',$language_info["dil_kod"]); 
	$settings = $db->query("select * from ayarlar where ayar_id = '1'")->fetch(PDO::FETCH_ASSOC); 
	$ayarlar = json_decode($settings["ayar_icerik"], true);

	  

	$Month = array(
		'01' => 'Ocak',
		'02' => 'Şubat',
		'03' => 'Mart',
		'04' => 'Nisan',
		'05' => 'Mayıs',
		'06' => 'Haziran',
		'07' => 'Temmuz',
		'08' => 'Ağustos',
		'09' => 'Eylül',
		'10' => 'Ekim',
		'11' => 'Kasım',
		'12' => 'Aralık'
	);
	
	// Dil ile ilgili fonksiyonlar
	function getDilListesi() {
		try {
			$db = checkDB();
			return $db->query("SELECT * FROM dil WHERE dil_durum = 1 ORDER BY dil_varsayilan DESC")
					 ->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			error_log("getDilListesi hatası: " . $e->getMessage());
			return [];
		}
	}

	function getVarsayilanDil() {
		try {
			$db = checkDB();
			$query = $db->prepare("SELECT * FROM dil WHERE dil_varsayilan = 1 AND dil_durum = 1 LIMIT 1");
			$query->execute();
			$varsayilan = $query->fetch(PDO::FETCH_ASSOC);
			return $varsayilan ?: ['dil_kod' => 'tr'];
		} catch (Exception $e) {
			error_log("getVarsayilanDil hatası: " . $e->getMessage());
			return ['dil_kod' => 'tr'];
		}
	}

	function getCurrentDil() {
		global $cookie_adi, $varsayilanDil;
		return isset($_COOKIE[$cookie_adi]) ? $_COOKIE[$cookie_adi] : $varsayilanDil;
	}

	function getDilById($dil_kod) {
		try {
			$db = checkDB();
			$query = $db->prepare("SELECT * FROM dil WHERE dil_kod = ? AND dil_durum = 1");
			$query->execute([$dil_kod]);
			return $query->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			error_log("getDilById hatası: " . $e->getMessage());
			return null;
		}
	}
	
	
	function getBayrakKodu($dil_kod) {
		// İngilizce için özel durum
		if (strtolower($dil_kod) == 'en') {
			return 'gb';
		}
		// Diğer diller için normal kod
		return strtolower(substr($dil_kod, 0, 2));
	}

	function checkDB() {
		global $db;
		if (!$db) {
			throw new Exception("Veritabanı bağlantısı bulunamadı");
		}
		return $db;
	}