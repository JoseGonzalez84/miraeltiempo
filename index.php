<?php

require_once './src/Curl.class.php';
require_once './src/WebContent.class.php';
require_once './components/Hidden.class.php';
require_once './components/Select.class.php';
require_once './components/MenuControl.class.php';

$menuControl = new MenuControl();
// Añadimos el boton de Inicio, siempre aparece.
$startButton = new Button(
    'Inicio',
    'primary',
    'http://localhost/miraeltiempo/',
    'house'
);
$startButton->build();
$menuControl->setButton($startButton);

$webContent = new WebContent('El tiempo');
$curlCall = new Curl();
$curlCall->setMethod('GET');
// Primera ventana.
if (empty($_POST) === true) :
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias');
    $allData = $curlCall->retrieveData();

    $webContent->setContent($menuControl->build());
    $webContent->setContent('<h1>Seleccione una provincia</h1>');
    $webContent->setContent('<form action="#" method="POST">');
    $hiddenProvinceSelection = new Hidden();
    $hiddenProvinceSelection->setName('seleccionProvincia');
    $hiddenProvinceSelection->setValue('1');
    $webContent->setContent($hiddenProvinceSelection->build(true));

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
    $webContent->setContent($selectProvinceSelection->build(true));
    $webContent->setContent('</form>');
endif;

// Seleccion de localidad.
if (isset($_POST['seleccionProvincia']) === true && $_POST['seleccionProvincia'] === '1') :
    $province = $_POST['listaProvincias'];
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias/'.$province.'/municipios');
    $allData = $curlCall->retrieveData();

    // Se añade el menú.
    $webContent->setContent($menuControl->build());
    $webContent->setTitle('El tiempo en '.$allData->provincia);
    $webContent->setContent('<h1>Seleccione una localidad</h1>');
    $webContent->setContent('<h3>Provincia: '.$allData->provincia.'</h3>');
    $webContent->setContent('<form action="#" method="POST">');

    $hiddenCitySelection = new Hidden();
    $hiddenCitySelection->setName('seleccionLocalidad');
    $hiddenCitySelection->setValue('1');
    $webContent->setContent($hiddenCitySelection->build(true));

    $hiddenProvinceSelected = new Hidden();
    $hiddenProvinceSelected->setName('selectedProvince');
    $hiddenProvinceSelected->setValue($province);
    $webContent->setContent($hiddenProvinceSelected->build(true));

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
    $webContent->setContent($selectCitySelection->build(true));
    $webContent->setContent('</form>');
endif;

if (isset($_POST['listaLocalidades']) === true && $_POST['seleccionLocalidad'] === '1') :
    $city = $_POST['listaLocalidades'];
    $province = $_POST['selectedProvince'];
    $curlCall->setUrl('https://www.el-tiempo.net/api/json/v2/provincias/'.$province.'/municipios/'.$city);
    $allData = $curlCall->retrieveData();

    $goBackButton = new Button();
    $goBackButton->setTitle('Volver atrás');
    $goBackButton->setType('link');
    $goBackButton->setUrl('http://localhost/miraeltiempo/');
    $goBackButton->setIcon('arrow-left');
    $goBackButton->isPost(true);
    $goBackButton->setDataForSend(
        [
        'seleccionProvincia' => '1',
        'listaProvincias' => $province
        ]
    );

    $goBackButton->build();
    $menuControl->setButton($goBackButton);

    $webContent->setContent($menuControl->build());
    $webContent->setContent('<h1>'.$allData->metadescripcion.'</h1>');
    foreach ($allData as $k => $lineData) {
        $webContent->setContent('<br>');
        $webContent->setContent($k);
        $webContent->setContent('<br>');
        $webContent->setContent($lineData);
        $webContent->setContent('<br>');
    }
endif;

$webContent->print();
