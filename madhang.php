<?php
date_default_timezone_set('Asia/Jakarta');


echo exec("clear");

awal:
$limitscan =3500;
echo @color('nevy',"\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
$timestamp = date("d-m-Y | H:i:s");
echo $timestamp;
echo "\SUPPORT BY M A D H A N G";
echo @color('nevy',"\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
echo "JANGAN LUPA BAHAGIA, YOU ARE READY TO CLAIM ALFA";
echo @color('nevy',"\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
echo "\n";

echo @color('green',"Pilih :\n");
echo @color('nevy', " 1. Register \n 2. Login\n");
echo @color('green', "Pilihan (1/2) ? ");
$pilihbarang = trim(fgets(STDIN));
echo "\n";
if($pilihbarang == 1){
    echo "\n";
    echo @color("green","REGISTER\n");
    echo @color("green","===================================\n");
    $sesid = sessionId();
    $uniqid = uniqueId();
    $nama = name();
    $email = strtolower(str_replace(" ", "", $nama) . mt_rand(100,999999) . "@gmail.com");
    echo @color("green","No. HP : ");
    $nohp = trim(fgets(STDIN));
    $data = '{"email":"'.$email.'","name":"'.$nama.'","phone":"+62'.$nohp.'","signed_up_country":"ID"}';
    $regist = post("https://api.gojekapi.com/v5/customers", $data, $sesid, $uniqid);
    //echo "\n";
    $adasda = json_decode($regist, true);
    //print_r($adasda);
    $otptoken=@$adasda["data"]["otp_token"];
    $message=@$adasda["data"]["message"];
    $errormsg=@$adasda["errors"][0]["message"];
    //echo $message;
    if($errormsg == "Nomor HP-mu sudah terdaftar."){
    //echo "\n";
        echo @color("red",$errormsg);
        echo "\n\n";
        echo @color("green","Ulangi ? ( y / n ) : ");
        $ulangi = trim(fgets(STDIN));
        if ($ulangi == "y") {
          goto awal;}
        else {
          echo "\n";
          echo @color("nevy", "Exiting script .....");
          echo "\n\n\n";
          die;}
    }
    
    ulangotp:
    //echo "\n";
    echo @color("green","OTP    : ");
    $otp = trim(fgets(STDIN));
    $data = '{"client_name":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","data":{"otp":"'.$otp.'","otp_token":"'.$otptoken.'"}}';
    $verify = post("https://api.gojekapi.com/v5/customers/phone/verify", $data, $sesid, $uniqid);
    echo "\n";
    $cxcx = json_decode($verify, true);
    $errro=@$cxcx["errors"][0]["message"];
    $id=@$cxcx["data"]["resource_owner_id"];
    $tokold=@$cxcx["data"]["access_token"];
    $reftok=@$cxcx["data"]["refresh_token"];
    if($errro == "Sepertinya kode yang kamu masukkan tidak valid."){
        echo @color("red",$errro);
        goto ulangotp;
    }
    goto autologin;
    
    $data = '{"client_id":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","data":{"refresh_token":"'.$reftok.'"},"grant_type":"refresh_token","scopes":[]}';
    $goid = postlog("https://goid.gojekapi.com/goid/token", $data, $sesid, $uniqid, $tokold, $id);
    $ahgad = json_decode($goid, true);
    $toknew=@$ahgad["access_token"];
    sleep(3);
    echo @color("green","PIN   : ");
    $pin = trim(fgets(STDIN));
    $data = '{"pin":"'.$pin.'"}';
    
    
    ulangpinotp:
    $pinnya = postsend("https://customer.gopayapi.com/v1/users/pin", $data, $sesid, $uniqid, $toknew, $id);
    $asdzzz1 = json_decode($pinnya, true);
    //echo "\n";
    print_r($asdzzz1);
    echo "\n";
    echo @colored("green","OTP PIN : ");
    $otpsetpin = trim(fgets(STDIN));
    $data = '{"pin":"'.$pin.'"}';
    $verify = postpin("https://customer.gopayapi.com/v1/users/pin", $data, $otpsetpin, $sesid, $uniqid, $toknew, $id);
    print_r($verify);
    echo "\n".@color("yellow","PIN OK")."\n";
    echo "\n".@color("green"," PIN ANDA $pin ")."\n";
    echo @color("green","  PIN ANDA $pin ")."\n";
    //echo @color("red"," SEMOGA CUAN ")."\n";
    $awalan = getRequest("https://api.gojekapi.com/goclub/v1/program", $uniqid, $sesid, $toknew, $id);
    $data = "";
    $member = postlogin("https://api.gojekapi.com/goclub/v1/members", $data, $sesid, $uniqid, $toknew, $id);
    print_r($member);
    echo "\n";
    $clubvc = getRequest("https://api.gojekapi.com/goclub/v1/membership", $uniqid, $sesid, $toknew, $id);
    echo "\n";
    // kita buat top up
    
    aloman:
/*
echo @colored("red","Notice !!");
echo @colored("green","Lakukan Topup  Terlebih Dahulu : \n");
echo @colored("blue"," - Untuk BCA Pake Kode 70001+nope (ex 70001081245xxxx) \n");
echo @colored("green"," - Untuk BRI Pake Kode 301341+nope (ex 301341081245xxxx) \n");
echo @colored("nevy"," - Admin Fee Rp 1.000 Min. Top Up Rp 10.000\n\n");
*/

    echo @colored("green","Sudah Top UP ? ( y / n ) : ");
    $yakah = trim(fgets(STDIN));
    $r1= "0";
    $r2= "7";
    for($r1; $r1 < $r2; $r1++){
      $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
      $duit = json_decode($balance, true);
      $duitmu=@$duit["data"][0]["balance"]["value"];
      echo @colored("green","$r1+1,. Saldo : ");
      while($duitmu = 0) {
        sleep(2);
        $duitmu=@$duit["data"][0]["balance"]["value"];
      }
      echo @colored("green",rupiah($duitmu));
      
      $landing = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
      $expnya = json_decode($landing, true);
      $expmu=@$expnya["data"]["current_tier"]["member_xp"];

      echo @colored("green"," EXP : ",$expmu);
      //echo "\n";
      if ($expmu>3900){
          echo @color('red',"EXP Limit !!!") ;
          die;
      }
      /*if($duitmu == "0"){
            echo "\n";
            echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
        sleep(10);
        }*/
      echo "\n";
//ini utk scan 500k
      $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
      //$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000039384102063938410303UMI51440014ID.CO.QRIS.WWW0215ID10200453788300303UMI5204581253033605409500000.005802ID5915Warung Mbak Mis6013KOTA SURABAYA6105602136214051039937188286304EF8F","type":"QR_CODE"}';
      $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
      $idempotency = sessionId();
      $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
      $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
      $aslila = json_decode($payment, true);
      $paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
      $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
      $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
      $ntonku = json_decode($apolah, true);
      $tokenwal=@$ntonku["data"][0]["token"];
      $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
      $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
      $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
      $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
      $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
      $data = '{"token":"'.$tokenwal.'"}';
      $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
      $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
      $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
      $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
      $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
      //print_r($patcikwo);
      echo "\n";
      sleep(10);
    }


/*

echo @colored("yellow","Scan Ke 7..\n");
echo @colored("nevy","Mohon Tunggu Sejenak Kawan....");
echo "\n";
sleep(90);
$a1= "0";
$a2= "7";
for($a1; $a1 < $a2; $a1++){
$balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$duit = json_decode($balance, true);
$duitmu=@$duit["data"][0]["balance"]["value"];
echo @colored("yellow","Saldo Anda : Rp ");
echo @colored("yellow",$duitmu);
if($duitmu == "0"){
    echo "\n";
    echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
sleep(20);
}
echo "\n";
//ini utk scan 500k
$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
$qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
$idempotency = sessionId();
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
$payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
$aslila = json_decode($payment, true);
$paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$ntonku = json_decode($apolah, true);
$tokenwal=@$ntonku["data"][0]["token"];
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"token":"'.$tokenwal.'"}';
$putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
print_r($patcikwo);
echo "\n";
sleep(15);
}
echo @colored("yellow","Scan Ke 14..\n");
echo @colored("green","Mohon Tunggu Sejenak Kawan....");
echo "\n";
sleep(90);
$c1= "0";
$c2= "7";
for($c1; $c1 < $c2; $c1++){
$balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$duit = json_decode($balance, true);
$duitmu=@$duit["data"][0]["balance"]["value"];
echo @colored("purple","Saldo Anda : Rp ");
echo @colored("purple",$duitmu);
if($duitmu == "0"){
    echo "\n";
    echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
sleep(20);
}
echo "\n";
//ini utk scan 500k
$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
$qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
$idempotency = sessionId();
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
$payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
$aslila = json_decode($payment, true);
$paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$ntonku = json_decode($apolah, true);
$tokenwal=@$ntonku["data"][0]["token"];
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"token":"'.$tokenwal.'"}';
$putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
print_r($patcikwo);
echo "\n";
sleep(15);
}
echo @colored("yellow","Scan Ke 21..\n");
echo @colored("red","Mohon Tunggu Sejenak Kawan....");
echo "\n";
sleep(90);
$e1= "0";
$e2= "7";
for($e1; $e1 < $e2; $e1++){
$balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$duit = json_decode($balance, true);
$duitmu=@$duit["data"][0]["balance"]["value"];
echo @colored("blue","Saldo Anda : Rp ");
echo @colored("blue",$duitmu);
if($duitmu == "0"){
    echo "\n";
    echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
sleep(20);
}
echo "\n";
//ini utk scan 500k
$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
$qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
$idempotency = sessionId();
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
$payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
$aslila = json_decode($payment, true);
$paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$ntonku = json_decode($apolah, true);
$tokenwal=@$ntonku["data"][0]["token"];
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"token":"'.$tokenwal.'"}';
$putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
print_r($patcikwo);
echo "\n";
sleep(15);
}
echo @colored("yellow","Scan Ke 28..\n");
echo @colored("nevy","Mohon Tunggu Sejenak Kawan....");
echo "\n";
sleep(90);
$f1= "0";
$f2= "7";
for($f1; $f1 < $f2; $f1++){
$balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$duit = json_decode($balance, true);
$duitmu=@$duit["data"][0]["balance"]["value"];
echo @colored("yellow","Saldo Anda : Rp ");
echo @colored("yellow",$duitmu);
if($duitmu == "0"){
    echo "\n";
    echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
sleep(20);
}
echo "\n";
//ini utk scan 500k
$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
$qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
$idempotency = sessionId();
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
$payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
$aslila = json_decode($payment, true);
$paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$ntonku = json_decode($apolah, true);
$tokenwal=@$ntonku["data"][0]["token"];
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"token":"'.$tokenwal.'"}';
$putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
print_r($patcikwo);
echo "\n";
sleep(15);
}
echo @colored("yellow","Scan Ke 35..\n");
scanlagi:
$balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$duit = json_decode($balance, true);
$duitmu=@$duit["data"][0]["balance"]["value"];
echo @colored("red","Saldo Anda : Rp ");
echo @colored("red",$duitmu);
echo "\n";
if($duitmu == "0"){
    echo "\n";
    echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
sleep(20);
}
echo "\n";



//ini utk scan 500k
$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
$qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
//print_r($qr500);
//echo "\n";
$idempotency = sessionId();
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
$payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
$aslila = json_decode($payment, true);
$paymentid=@$aslila["data"]["payment_id"];
//print_r($payment);
//echo "\n";
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
$ntonku = json_decode($apolah, true);
$tokenwal=@$ntonku["data"][0]["token"];
$ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
$last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
$data = '{"token":"'.$tokenwal.'"}';
$putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
$data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
$patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
print_r($patcikwo);
echo "\n";
sleep(15);

*/

/*$landing = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
$expnya = json_decode($landing, true);
$expmu=@$expnya["data"]["current_tier"]["member_xp"];
echo @colored("yellow"," EXP mu Sekarang Adalah : ");
echo @colored("green",$expmu);
echo "\n";
echo @color("nevy"," Kurang Puas ? Mau Scan LAgi ? ( y / n ) : ");
$pilihbarangnya = trim(fgets(STDIN));
echo "\n";
if($pilihbarangnya == "y"){
echo @colored("purple","Oke, Scan Lagi");
echo "\n";
goto scanlagi;
}
echo "\n";
echo exec("mpv /sdcard/music");
echo "\n";
echo @colored("green","Selesai Scan, Apakah Mau Reedem Kupon ? ( y / n )");
$pilinjoku = trim(fgets(STDIN));
if($pilinjoku == "y"){
    echo "\n";
    goto redemkupon;
}
*/

}



//if pilihbarang sampe sini


if($pilihbarang == 2){
    echo "\n";
    autologin:
    echo @color("green","LOGIN\n");
    echo @color("green","===================================\n");
    echo @color("green","No. HP : ");
    //echo @colored("nevy","Masukkan Nomor : ");
    $nohp = trim(fgets(STDIN));
//echo "\n";
    $sesid = sessionId();
    //echo ($sesid);
    //echo "\n";
    $uniqid = uniqueId();
    //echo($uniqid);
    $data = '{"client_id":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","country_code":"+62","magic_link_ref":"","phone_number":"'.$nohp.'"}';
    $regist = post("https://goid.gojekapi.com/goid/login/request", $data, $sesid, $uniqid);
    $cxcx = json_decode($regist, true);
    $otptok=@$cxcx["data"]["otp_token"];
    $sda=@$cxcx["success"];
    echo @colored("green","OTP    : ");
    //echo @colored("purple"," Masukkan OTP : ");
    $otp = trim(fgets(STDIN));
    $data = '{"client_id":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","data":{"otp":"'.$otp.'","otp_token":"'.$otptok.'"},"grant_type":"otp","scopes":[]}';
    $dasdas = post("https://goid.gojekapi.com/goid/token", $data, $sesid, $uniqid);
    $cxdasdcx = json_decode($dasdas, true);
    $toknew=@$cxdasdcx["access_token"];
    //echo "\n";
    //sleep(3);
    $ntah = getcust("https://api.gojekapi.com/gojek/v2/customer", $uniqid, $sesid, $toknew);
    $cxcxcxa = json_decode($ntah, true);
    $id=@$cxcxcxa["customer"]["id"];
    $namany=@$cxcxcxa["customer"]["name"];
    echo @colored("green","Nama   : $namany\n");
    echo @colored("green","PIN    : ");
    //echo @colored("yellow"," Masukkan PIN Anda : ");
    $pin = trim(fgets(STDIN));
    $data = '{"pin":"'.$pin.'"}';
    ulangpinotpd:
    $pinnya = postsend("https://customer.gopayapi.com/v1/users/pin", $data, $sesid, $uniqid, $toknew, $id);
    $asdzzz = json_decode($pinnya, true);
    $erasd=@$asdzzz["access_token"];
    echo "\n";
    //$tes=@$asdzzz["access_token"];
    //print_r($pinnya);
    print_r($asdzzz);

    $errormsg1=@$asdzzz["errors"][0]["message_title"];
    //echo $errormsg1;
    if($errormsg1 != "PIN sudah terpasang"){
        //echo "\n";
        //echo ($pinnya[errors][code]);
        echo @colored("green","OTP PIN : ");
        //echo @colored("purple"," Masukkan OTP Pin Anda : ");
        $otpsetpin = trim(fgets(STDIN));
        $data = '{"pin":"'.$pin.'"}';
        $verify = postpin("https://customer.gopayapi.com/v1/users/pin", $data, $otpsetpin, $sesid, $uniqid, $toknew, $id);
        //print_r($verify);
    /*echo "\n".@color("yellow","  PIN SUDAH TERPASANG ")."\n";
    echo "\n".@color("green"," PIN ANDA $pin ")."\n";
    echo @color("green","  PIN ANDA $pin ")."\n";
    echo @color("red"," SEMOGA CUAN ")."\n";
    */
    }
        $awalan = getRequest("https://api.gojekapi.com/goclub/v1/program", $uniqid, $sesid, $toknew, $id);
        $data = "";
        $member = postlogin("https://api.gojekapi.com/goclub/v1/members", $data, $sesid, $uniqid, $toknew, $id);
        
        //print_r($member);
        echo "\n";
        $clubvc = getRequest("https://api.gojekapi.com/goclub/v1/membership", $uniqid, $sesid, $toknew, $id);
        echo "\n";
    
    // kita buat top up
    //goto aloman;
        alomana:
        $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
        $duit = json_decode($balance, true);
        $duitmu=@$duit["data"][0]["balance"]["value"];
        $landing = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
        $expnya = json_decode($landing, true);
        $expmu=@$expnya["data"]["current_tier"]["member_xp"];
    
        echo @color('green', "SALDO = ");
        echo @color('green', rupiah($duitmu));
        //sleep(5);
        echo @color("green", " -- EXP = $expmu");
        echo "\n\n";
        echo @color("green","Rolling Scan (35x@Rp.500.000) ? ( y/n ) : ");
        //echo "\n";
        $yakah = trim(fgets(STDIN));
        $r1= "0";
        $r2= "7";
        while($expmu <= $limitscan) {
            

        //for($r1; $r1 < $r2; $r1++){
          
          //ini utk scan 500k
            $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
            //$data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000039384102063938410303UMI51440014ID.CO.QRIS.WWW0215ID10200453788300303UMI5204581253033605409500000.005802ID5915Warung Mbak Mis6013KOTA SURABAYA6105602136214051039937188286304EF8F","type":"QR_CODE"}';
            $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
            //print_r($qr500);
            //echo "\n";
            $idempotency = sessionId();
            $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
            $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
            $aslila = json_decode($payment, true);
            $paymentid=@$aslila["data"]["payment_id"];
            //print_r($payment);
            //echo "\n";
            $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
            $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
            $ntonku = json_decode($apolah, true);
            $tokenwal=@$ntonku["data"][0]["token"];
            $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
            $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
            $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
            $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
            $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
//print_r($dapekdak);
//echo "\n";
            $data = '{"token":"'.$tokenwal.'"}';
            $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
//print_r($putra);
//echo "\n";
            $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
            $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
//print_r($patcik);
//echo "\n";
            $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
            $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
            $lalala = json_decode($patcikwo, true);
            $test99=@$lalala["success"];
            /*print_r($lalala);
            echo rupiah($test99);*/
            echo "\n";
            echo @color('green', $r1+1);
            echo @color('green',". SCAN Status = ");

            $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
            $duit = json_decode($balance, true);
            $duitmu=@$duit["data"][0]["balance"]["value"];
            $landing = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
            $expnya = json_decode($landing, true);
            $expmu=@$expnya["data"]["current_tier"]["member_xp"];
    
            if ($test99 == true) {
              echo @color('blue',"Success");
              //if ($expmu1 == $expmu){
                $expmu=$expmu+100;
              //}
            }
            else {
              echo @color('red',"Failed! Delay 120s.");
              sleep(120);
            }
            echo "\n";
            echo @color('green', "==> SALDO = ");
         
            while($duitmu == 0) {
                sleep(1);
                //echo $duitmu;
                echo @color('nevy', "*");
                $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
                $duit = json_decode($balance, true);
                $duitmu=@$duit["data"][0]["balance"]["value"];
            }
            
            echo @color('green', " ".rupiah($duitmu));
            echo "\n";
            //sleep(5);
            echo @color('green', "==> EXP   = $expmu");
            echo "\n";
            $r1++;
            //sleep(10);
        }
        
        if ($expmu>$limitscan){
            echo "\n";
            echo @color('red',"EXP Limit !!!") ;
            echo "\n\n";
            goto redemkupon;
        }
    /*
    echo @colored("red","Notice !!\n");
    echo @colored("green","Lakukan Topup  Terlebih Dahulu : \n");
    echo @colored("blue"," - Untuk BCA Pake Kode 70001+nope (ex 70001081245xxxx) \n");
    echo @colored("green"," - Untuk BRI Pake Kode 301341+nope (ex 301341081245xxxx) \n");
    echo @colored("nevy"," - Admin Fee Rp 1.000 Min. Top Up Rp 10.000\n\n");
    echo @colored("yellow"," Apakah Sudah Top UP ? ( y / n ) : ");
    $yakah = trim(fgets(STDIN));
    $r1= "0";
    $r2= "7";
    for($r1; $r1 < $r2; $r1++){
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("green","Saldo Anda : Rp ");
    echo @colored("green",$duitmu);
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    }
    echo @colored("yellow","Scan Ke 7..\n");
    echo @colored("nevy","Mohon Tunggu Sejenak Kawan....");
    echo "\n";
    sleep(90);
    $a1= "0";
    $a2= "7";
    for($a1; $a1 < $a2; $a1++){
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("yellow","Saldo Anda : Rp ");
    echo @colored("yellow",$duitmu);
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    }
    echo @colored("yellow","Scan Ke 14..\n");
    echo @colored("green","Mohon Tunggu Sejenak Kawan....");
    echo "\n";
    sleep(90);
    $c1= "0";
    $c2= "7";
    for($c1; $c1 < $c2; $c1++){
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("purple","Saldo Anda : Rp ");
    echo @colored("purple",$duitmu);
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    }
    echo @colored("yellow","Scan Ke 21..\n");
    echo @colored("red","Mohon Tunggu Sejenak Kawan....");
    echo "\n";
    sleep(90);
    $e1= "0";
    $e2= "7";
    for($e1; $e1 < $e2; $e1++){
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("blue","Saldo Anda : Rp ");
    echo @colored("blue",$duitmu);
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    }
    echo @colored("yellow","Scan Ke 28..\n");
    echo @colored("nevy","Mohon Tunggu Sejenak Kawan....");
    echo "\n";
    sleep(90);
    $f1= "0";
    $f2= "7";
    for($f1; $f1 < $f2; $f1++){
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("yellow","Saldo Anda : Rp ");
    echo @colored("yellow",$duitmu);
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    }
    echo @colored("yellow","Scan Ke 35..\n");
    scanlagid:
    $balance = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($balance, true);
    $duitmu=@$duit["data"][0]["balance"]["value"];
    echo @colored("red","Saldo Anda : Rp ");
    echo @colored("red",$duitmu);
    echo "\n";
    if($duitmu == "0"){
        echo "\n";
        echo @colored("green","Tunggu Jon, Duitmu Belum Balik..");
    sleep(20);
    }
    echo "\n";
    //ini utk scan 500k
    $data = '{"data":"00020101021226590016ID.CO.SHOPEE.WWW011893600918000091808002069180800303UMI51440014ID.CO.QRIS.WWW0215ID10210657735380303UMI5204539953033605409500000.005802ID5913amira pampers6013KAB. SIDOARJO61056125362290525WFqSVKgqPU870n0yXtc8nyNhH63049883","type":"QR_CODE"}';
    $qr500 = postlogin("https://customer.gopayapi.com/v1/explore", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($qr500);
    //echo "\n";
    $idempotency = sessionId();
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"amount":{"currency":"IDR","value":500000},"channel_type":"DYNAMIC_QR","checksum":{"version":"3","value":"95022321"},"fetch_promotion_details":true,"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payee":{"id":"6c75a094-eca7-4257-bfbd-70148ea92b51","type":"MERCHANT"},"payment_intent":"DYNAMIC_QR_OFF_US"}';
    $payment = postpay("https://customer.gopayapi.com/customers/v1/payments", $data, $idempotency, $sesid, $uniqid, $toknew, $id);
    $aslila = json_decode($payment, true);
    $paymentid=@$aslila["data"]["payment_id"];
    //print_r($payment);
    //echo "\n";
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $apolah = getRequest("https://customer.gopayapi.com/v1/payment-options/balances", $uniqid, $sesid, $toknew, $id);
    $ntonku = json_decode($apolah, true);
    $tokenwal=@$ntonku["data"][0]["token"];
    $ntah = getRequest("https://customer.gopayapi.com/v1/customer/payment-options?intent=DYNAMIC_QR_OFF_US", $uniqid, $sesid, $toknew, $id);
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $dapekdak = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"transactions":[{"net_spend":500000,"payment_type":"GOPAY_WALLET","service_type":99}]}';
    $last = postlogin("https://api.gojekapi.com/goclub/v1/estimate-xp", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($dapekdak);
    //echo "\n";
    $data = '{"token":"'.$tokenwal.'"}';
    $putra = postput("https://customer.gopayapi.com/v1/customer/payment-options/settings/last-used", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($putra);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcik = postpatch("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $sesid, $uniqid, $toknew, $id);
    //print_r($patcik);
    //echo "\n";
    $data = '{"additional_data":{"merchant_order_id":"","aspiqr_information":{"additional_data_national":"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH","merchant_city":"KAB. SIDOARJO","retrieval_reference_number":"","transaction_currency_code":"360","merchant_id":"918080","purpose_of_transaction":"","store_label":"","terminal_label":"","bill_number":"","qr_transaction_type":"OFF-US-GOPAY-ISSUER","loyalty_number":"","merchant_criteria":"UMI","reference_label":"WFqSVKgqPU870n0yXtc8nyNhH","merchant_pan":"936009180000918080","additional_consumer_data_request":"","merchant_category_code":"5399","trx_fee_amount":0.0,"merchant_name":"amira pampers","issuer_name":"gopay","issuer_id":"93600914","acquirer_name":"Airpay Shopee","country_code":"ID","acquirer_id":"93600918","customer_label":"","postal_code":"61253","mobile_number":""}},"applied_promo_code":["NO_PROMO_APPLIED"],"checksum":{"version":"3","value":"95022321"},"metadata":{"merchant_cross_reference_id":"6c75a094-eca7-4257-bfbd-70148ea92b51","payment_widget_intent":"DYNAMIC_QR_OFF_US","aspi_qr_acquirer":"airpay shopee","aspi_qr_data":"{\"amount\":500000,\"postal_code\":\"61253\",\"merchant_city\":\"KAB. SIDOARJO\",\"merchant_id\":\"918080\",\"merchant_criteria\":\"UMI\",\"merchant_pan\":\"936009180000918080\",\"country_code\":\"ID\",\"transaction_currency_code\":\"360\",\"additional_data_national\":\"61056125362290525WFqSVKgqPU870n0yXtc8nyNhH\",\"additional_data\":{\"store_label\":null,\"mobile_number\":null,\"reference_label\":\"WFqSVKgqPU870n0yXtc8nyNhH\",\"purpose_of_transaction\":null,\"customer_label\":null,\"terminal_label\":null,\"bill_number\":null,\"additional_consumer_data_request\":null,\"loyalty_number\":null},\"merchant_category_code\":\"5399\",\"merchant_name\":\"amira pampers\",\"trx_fee_amount\":0,\"acquirer_id\":\"93600918\"}","external_merchant_name":"amira pampers - Airpay Shopee","checksum":"{\"version\":\"3\",\"value\":\"95022321\"}","channel_type":"DYNAMIC_QR","aspi_qr_transaction_type":"OFF-US-GOPAY-ISSUER","aspi_qr_issuer":"gopay","tags":"{ \"service_type\": \"GOPAY_OFFLINE\" }"},"order_signature":{"reason":"","partner_id":"","partner_name":"","source":"","channel_type":"","transaction_type":"","customer_fulfillment_type":""},"payment_token":"'.$tokenwal.'"}';
    $patcikwo = postpatchwo("https://customer.gopayapi.com/customers/v1/payments/".$paymentid."/capture", $data, $pin, $sesid, $uniqid, $toknew, $id);
    print_r($patcikwo);
    echo "\n";
    sleep(15);
    $landing = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
    $expnya = json_decode($landing, true);
    $expmu=@$expnya["data"]["current_tier"]["member_xp"];
    echo @colored("yellow"," EXP mu Sekarang Adalah : ");
    echo @colored("green",$expmu);
    echo "\n";
    echo @color("nevy"," Kurang Puas ? Mau Scan LAgi ? ( y / n ) : ");
    $pilihbarangnya = trim(fgets(STDIN));
    echo "\n";
    if($pilihbarangnya == "y"){
    echo @colored("purple","Oke, Scan Lagi");
    echo "\n";
    goto scanlagid;
    }
    echo exec("mpv /sdcard/music");
    echo "\n";
    echo @colored("green","Selesai Scan, Apakah Mau Reedem Kupon ? ( y / n )");
    echo "\n";
    $pilinjoku = trim(fgets(STDIN));
    echo "\n";
    if($pilinjoku == "y"){
        goto redemkupon;
    }*/
    }
//goto awal;

    redemkupon:
    echo @colored("green","Redeem Voucher CB Alfamart : \n");
/*echo @colored("red"," 1  . Alfamart\n");
echo @colored("nevy"," 2  . GPC\n");
echo @colored("yellow"," 1 / 2 ? : ");
$gaskanbosssss = trim(fgets(STDIN));*/
    echo "\n";

//if($gaskanbosssss == 1){
    ambilterusssc:
$lp = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($lp, true);
    $tc=@$duit["data"]["current_tier"]["treasure_cards"][0]["id"];
ulanglagiyaac:
$balance = getRequest("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $uniqid, $sesid, $toknew, $id);
$select = json_decode($balance, true);
$satu=@$select["data"]["claim_from"][0]["id"];
$namasatu=@$select["data"]["claim_from"][0]["details"]["title"];
$dua=@$select["data"]["claim_from"][1]["id"];
$namadua=@$select["data"]["claim_from"][1]["details"]["title"];
$tiga=@$select["data"]["claim_from"][2]["id"];
$namatiga=@$select["data"]["claim_from"][2]["details"]["title"];
if($namasatu == ""){
    goto habisgana;
}
//echo @colored("nevy","Tunggu Sejenak..\n");
if($namasatu == "Cashback GoPay 10rb jajan & belanja"){
    echo @colored("green",$namasatu);
    $idb = $satu;
    echo " ";
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusssc;
}elseif($namadua == "Cashback GoPay 10rb jajan & belanja"){
    echo @colored("green",$namadua);
    echo " ";
    $idb = $dua;
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusssc;
}elseif($namatiga == "Cashback GoPay 10rb jajan & belanja"){
    echo @colored("green",$namatiga);
echo " ";
    $idb = $tiga;
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusssc;
}else{
    //echo "\n";
    //echo @colored("purple","Ulang Lagi Ya");
    echo "\n";
    goto ulanglagiyaac;
}
//}

/*
if($gaskanbosssss == 2){
    ambilterusa:
    $lp = getRequest("https://api.gojekapi.com/goclub/v1/landing-page", $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($lp, true);
    $tc=@$duit["data"]["current_tier"]["treasure_cards"][0]["id"];
ulanglagiyaaa:
$balance = getRequest("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $uniqid, $sesid, $toknew, $id);
$select = json_decode($balance, true);
$satu=@$select["data"]["claim_from"][0]["id"];
$namasatu=@$select["data"]["claim_from"][0]["details"]["title"];
$dua=@$select["data"]["claim_from"][1]["id"];
$namadua=@$select["data"]["claim_from"][1]["details"]["title"];
$tiga=@$select["data"]["claim_from"][2]["id"];
$namatiga=@$select["data"]["claim_from"][2]["details"]["title"];
if($namasatu == ""){
    goto habisgana;
}
echo @colored("nevy","Tunggu Sejenak..\n");
if($namasatu == "Cashback GoPay 75% belanja & ngegame"){
    echo @colored("green",$namasatu);
    echo " ";
    $idb = $satu;
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusa;
}elseif($namadua == "Cashback GoPay 75% belanja & ngegame"){
    echo @colored("green",$namadua);
    echo " ";
    $idb = $dua;
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusa;
}elseif($namatiga == "Cashback GoPay 75% belanja & ngegame"){
    echo @colored("green",$namatiga);
    echo " ";
    $idb = $tiga;
    $data = '{"select_benefit":"'.$idb.'"}';
    $payment = postpatchklem("https://api.gojekapi.com/goclub/v1/user-claims/".$tc, $data, $uniqid, $sesid, $toknew, $id);
    $duit = json_decode($payment, true);
    $statusclaim=@$duit["data"]["status"];
    echo @colored("green",$statusclaim);
    echo "\n";
    goto ambilterusa;
}else{
    echo "\n";
    echo @colored("purple","Ulang Lagi Ya");
    echo "\n";
    goto ulanglagiyaaa;
}
}
*/
habisgana:
echo "\n";
//echo "Habis Jon Ganti Nomor Lagi\n\n";
$claimed = getRequest("https://api.gojekapi.com/goclub/v1/user-claims?status=CLAIMED", $uniqid, $sesid, $toknew, $id);
$josss = json_decode($claimed, true);
$q=@$josss["data"][0]["benefit"]["details"]["title"];
$w=@$josss["data"][1]["benefit"]["details"]["title"];
$e=@$josss["data"][2]["benefit"]["details"]["title"];
$r=@$josss["data"][3]["benefit"]["details"]["title"];
$t=@$josss["data"][4]["benefit"]["details"]["title"];
$y=@$josss["data"][5]["benefit"]["details"]["title"];
$u=@$josss["data"][6]["benefit"]["details"]["title"];
$i=@$josss["data"][7]["benefit"]["details"]["title"];
$o=@$josss["data"][8]["benefit"]["details"]["title"];
$p=@$josss["data"][9]["benefit"]["details"]["title"];
$a=@$josss["data"][10]["benefit"]["details"]["title"];
$s=@$josss["data"][11]["benefit"]["details"]["title"];
$d=@$josss["data"][12]["benefit"]["details"]["title"];
echo @colored("yellow","My Voucher : \n");
echo " 1 . $q\n";
echo " 2 . $w\n";
echo " 3 . $e\n";
echo " 4 . $r\n";
echo " 5 . $t\n";
echo " 6 . $u\n";
echo " 7 . $i\n";
echo " 8 . $o\n";
echo " 9 . $p\n";
echo " 10. $a\n";
echo " 11. $s\n";
echo " 12. $d\n";
echo " 13. $q\n\n";
goto awal;

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}

function angka($angka){
	
	$hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}

function getcust($url, $uniqid, $sesid, $toknew)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $header[]='x-platform: Android';
      $header[]='x-uniqueid: '.$uniqid;
      $header[]='x-appversion: 4.23.2';
      $header[]='x-appid: com.gojek.app';
      $header[]='accept: application/json';
      $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
      $header[]='x-session-id: '.$sesid;
      $header[]='authorization: Bearer '.$toknew;
      $header[]='x-user-type: customer';
      $header[]='x-deviceos: Android,5.1';
      $header[]='user-uuid: ';
      $header[]='x-devicetoken: ';
      $header[]='x-phonemake: Samsung';
      $header[]='x-pushtokentype: FCM';
      $header[]='x-phonemodel: samsung,Gt-p3100';
      $header[]='accept-language: id';
      $header[]='x-user-locale: id';
      $header[]='gojek-country-code: ID';
      $header[]='content-type: application/json; charset=UTF-8';
      $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postput($url, $data=null, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='d1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,8.0';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-G970F';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}

function postpatchwo($url, $data=null, $pin, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='pin: '.$pin;
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,8.1';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-G950F';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}


function postpatchklem($url, $data=null, $uniqid, $sesid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,5.1';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,Gt-p3100';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postpatch($url, $data=null, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='pin: ';
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,9.0';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-G973F';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postpay($url, $data=null, $idempotency, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='idempotency-key: '.$idempotency;
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,7.0';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-T813';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postpin($url, $data=null, $otpsetpin, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='otp: '.$otpsetpin;
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,5.1';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,Gt-p3100';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postsend($url, $data=null, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,11.0';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-T970';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='Connection: Keep-Alive';
           $header[]='content-type: application/json; charset=UTF-8';           
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postlogin($url, $data=null, $sesid, $uniqid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$toknew;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,10.0';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-G988B';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='gojek-country-code: ID';
           $header[]='content-type: application/json; charset=UTF-8';
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function getRequest($url, $uniqid, $sesid, $toknew, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $header[]='x-platform: Android';
      $header[]='x-uniqueid: '.$uniqid;
      $header[]='x-appversion: 4.23.2';
      $header[]='x-appid: com.gojek.app';
      $header[]='accept: application/json';
      $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
      $header[]='x-session-id: '.$sesid;
      $header[]='authorization: Bearer '.$toknew;
      $header[]='x-user-type: customer';
      $header[]='x-deviceos: Android,5.1';
      $header[]='user-uuid: '.$id;
      $header[]='x-devicetoken: ';
      $header[]='x-phonemake: Samsung';
      $header[]='x-pushtokentype: FCM';
      $header[]='x-phonemodel: samsung,Gt-p3100';
      $header[]='accept-language: id';
      $header[]='x-user-locale: id';
      $header[]='gojek-country-code: ID';
      $header[]='content-type: application/json; charset=UTF-8';
      $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function postlog($url, $data=null, $sesid, $uniqid, $tokold, $id)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer '.$tokold;
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,6.0.1';
           $header[]='user-uuid: '.$id;
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,SM-A500FU';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='content-type: application/json; charset=UTF-8';
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function sessionId()
{
      return sprintf(
         '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0x0fff) | 0x4000,
         mt_rand(0, 0x3fff) | 0x8000,
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
}
function uniqueId()
{
      return sprintf(
         '%04x%04x%04x%04x',
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0x0fff) | 0x4000,
         mt_rand(0, 0x3fff) | 0x8000,
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
}
function name()
    {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ex = curl_exec($ch);
    // $rand = json_decode($rnd_get, true);
    preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
    return $name[2][mt_rand(0, 14) ];
    }

function post($url, $data=null, $sesid, $uniqid)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
           $header[]='x-platform: Android';
           $header[]='x-uniqueid: '.$uniqid;
           $header[]='x-appversion: 4.23.2';
           $header[]='x-appid: com.gojek.app';
           $header[]='accept: application/json';
           $header[]='D1: 47:1D:6B:6F:70:38:E3:70:56:15:75:13:71:49:90:2F:CC:82:9F:0E:E5:D8:D2:89:A9:AD:EF:98:C1:D3:43:D5';
           $header[]='x-session-id: '.$sesid;
           $header[]='authorization: Bearer ';
           $header[]='x-user-type: customer';
           $header[]='x-deviceos: Android,5.1';
           $header[]='user-uuid: ';
           $header[]='x-devicetoken: ';
           $header[]='x-phonemake: Samsung';
           $header[]='x-pushtokentype: FCM';
           $header[]='x-phonemodel: samsung,Gt-p3100';
           $header[]='accept-language: id';
           $header[]='x-user-locale: id';
           $header[]='content-type: application/json; charset=UTF-8';
           $header[]='user-agent: okhttp/3.12.13';
     curl_setopt($ch, CURLOPT_AUTOREFERER, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_COOKIEJAR, "klik.txt");
     curl_setopt($ch, CURLOPT_COOKIEFILE, "klik.txt");
     $response = curl_exec($ch);
     $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    print_r ($json);
    return $response;
}
function colored($color = "default" , $text)
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
function color($color = "default" , $text)
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
    function d1($v28, $w29)
{
    $s2a = fopen($v28, "a");
    fputs($s2a, $w29);
    fclose($s2a);
}
function save($filename, $content)
{
    $save = fopen($filename, "a");
    fputs($save, $content);
    fclose($save);
}
?>