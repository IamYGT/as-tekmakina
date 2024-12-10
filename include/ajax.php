<?php  require("baglan.php");require("fonksiyon.php");
/* 	if(substr_count($_SERVER['PHP_SELF'], 'ajax.php'))
		exit(); */
	if(isset($action)){
		if($action == "row") {
			if($do == 'page'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE icerikler SET row = {$key} WHERE icerik_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'menu'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE menuler SET row = {$key} WHERE menu_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row g��ncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'slayt'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE slayt SET row = {$key} WHERE slayt_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'news'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE haberler SET row = {$key} WHERE haber_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'galleries'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE galeriler SET row = {$key} WHERE galeri_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'projects'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE projeler SET row = {$key} WHERE proje_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'brands'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE markalar SET row = {$key} WHERE marka_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'references'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE referanslar SET row = {$key} WHERE referans_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'teams'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE ekibimiz SET row = {$key} WHERE ekip_ust_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'hiddenfeature'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE gizli_ozellikler SET row = {$key} WHERE gizli_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'carsmodel'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE arac_model SET row = {$key} WHERE model_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'yearscar'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE arac_yil SET row = {$key} WHERE yil_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başarılı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'cars'){
				if (is_array($item) ){
					foreach ($item as $key => $value ){
						$key = $key+1;
						$update = $db->exec("UPDATE arac_tip SET row = {$key} WHERE arac_id = {$value};");	 
					}
					if($update){
						$response = array(
							'islemSonuc' => true, 
							'islemMsj' => '<div class="alert alert-secondary solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Başar��lı şekilde Row güncellendi.</p>
											</div>'
						);
					} else {
						$response = array(
							'islemSonuc' => false,
							'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
												<strong>İşlem Sonucu!</strong>
												<p>Row güncellenirken bir hata oluştu.</p>
											</div>'
						);
					}
				}else{
					$response = array(
						'islemSonuc' => false,
						'islemMsj' => '<div class="alert alert-danger solid alert-dismissible fade show">
											<strong>İşlem Sonucu!</strong>
											<p>Gönderilen veri dizi değil lütfen tekrar deneyiniz.</p>
										</div>'
					);
				} 
				if(isset($response)){
					echo json_encode($response);
				}
			}else if($do == 'projects' && $action == 'row') {
				try {
					if(!isset($_POST['item']) || !is_array($_POST['item'])) {
						throw new Exception('Geçersiz sıralama verisi');
					}

					$db->beginTransaction();
					
					$items = $_POST['item'];
					$count = 1;
					
					foreach($items as $item) {
						$update = $db->prepare("UPDATE projeler SET row = ? WHERE proje_ust_id = ?");
						$result = $update->execute([$count, $item]);
						
						if(!$result) {
							throw new Exception('Sıralama güncellenirken hata oluştu');
						}
						
						$count++;
					}
					
					$db->commit();
					$response = array('status' => 'success', 'message' => 'Sıralama güncellendi');
					
				} catch(Exception $e) {
					if($db->inTransaction()) {
						$db->rollBack();
					}
					$response = array('status' => 'error', 'message' => 'Hata: ' . $e->getMessage());
				}
				
				header('Content-Type: application/json');
				echo json_encode($response);
				exit;
			}
		}
	}