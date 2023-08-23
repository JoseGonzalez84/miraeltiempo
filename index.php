<?php

require_once './src/Curl.class.php';
require_once './src/WebContent.class.php';
require_once './components/Hidden.class.php';
require_once './components/Select.class.php';

$webContent = new WebContent('El tiempo');
$curlCall = new Curl();
$curlCall->setMethod('GET');

if (empty($_POST) === true) :
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias');
    $allData = $curlCall->retrieveData();
    ?>
<h1>Seleccione una provincia</h1>
<form action="#" method="POST">
    <?php
        $hiddenProvinceSelection = new Hidden();
        $hiddenProvinceSelection->setName('seleccionProvincia');
        $hiddenProvinceSelection->setValue('1');
        $hiddenProvinceSelection->build();

        $provinceOptions = [];
        foreach ($allData as $k => $lineData) {
            if ($k === 'provincias') {
                foreach ($lineData as $provinceInfo) {
                    $provinceOptions[] = [$provinceInfo->CODPROV => $provinceInfo->NOMBRE_PROVINCIA];
                }
            }
        }

        $selectProvinceSelection = new Select($provinceOptions);
        $selectProvinceSelection->setName('listaProvincias');
        $selectProvinceSelection->setOnChange('this.form.submit()');
        $selectProvinceSelection->build();
    ?>
</form>

    <?php
endif;
if (isset($_POST['seleccionProvincia']) === true && $_POST['seleccionProvincia'] === '1') :
    $province = $_POST['listaProvincias'];
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias/'.$province.'/municipios');
    $allData = $curlCall->retrieveData();
    ?>
<h1>Seleccione una localidad</h1>
<h3>Provincia: <?php echo $allData->provincia; ?></h3>
<form action="#" method="POST">
    <?php
    $hiddenCitySelection = new Hidden();
    $hiddenCitySelection->setName('seleccionLocalidad');
    $hiddenCitySelection->setValue('1');
    $hiddenCitySelection->build();
    $hiddenProvinceSelected = new Hidden();
    $hiddenProvinceSelected->setName('selectedProvince');
    $hiddenProvinceSelected->setValue($province);
    $hiddenProvinceSelected->build();

    $cityOptions = [];
    foreach ($allData as $k => $lineData) {
        if ($k === 'municipios') {
            foreach ($lineData as $cityInfo) {
                $cityOptions[] = [substr($cityInfo->CODIGOINE, 0, 5) => $cityInfo->NOMBRE];
            }
        }
    }

    $selectCitySelection = new Select($cityOptions);
    $selectCitySelection->setName('listaLocalidades');
    $selectCitySelection->setOnChange('this.form.submit()');
    $selectCitySelection->build();
    ?>
</form>
    <?php
endif;
if (isset($_POST['listaLocalidades']) === true && $_POST['seleccionLocalidad'] === '1') :
    $city = $_POST['listaLocalidades'];
    $province = $_POST['selectedProvince'];
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias/'.$province.'/municipios/'.$city);
    $allData = $curlCall->retrieveData();
    ?>
        <h1><?php echo $allData->metadescripcion ?></h1>
    <?php
    foreach ($allData as $k => $lineData) {
        echo "<br>";
        var_dump($k);
        echo "<br>";
        var_dump($lineData);
        echo "<br>";
    }
endif;
?>
