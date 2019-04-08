<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       // ESTADO DE USUARIOS
       $statusUserList = [
            ['id' => 0, 'name' => 'Inactivo'],
            ['id' => 1, 'name' => 'Activo'],
        ];
        \App\Models\UserStatus::insert($statusUserList);


        // POSICION DEL PERSONAL
        $UserPositionList = [
            ['id' => 1, 'name' => 'Administración'],
            ['id' => 2, 'name' => 'Acesor de Jardin'],
            ['id' => 3, 'name' => 'Paisajista'],
        ];
        \App\Models\UserPosition::insert($UserPositionList);


        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@gc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('gc12345*-'),
            'active_id' => 1,
            'position_id' => 1
        ]);


        // TYPO DE INFORMACION
        $TypeInfoList = [
            ['id' => 1, 'name' => 'Cotización'],
            ['id' => 2, 'name' => 'Catalogo'],
            ['id' => 3, 'name' => 'Imagenes'],
            ['id' => 4, 'name' => 'Publicidad'],
            ['id' => 5, 'Poductos' => 'Imagenes'],
        ];
        \App\Models\TypeInfo::insert($TypeInfoList);


        // TYPO DE INFORMACION DETALLES
        $TypeInfoDetailList = [
            ['info_id' => 1, 'name' => 'Escrita'],
            ['info_id' => 1, 'name' => 'Virtual'],
            ['info_id' => 2, 'name' => 'Fisicos'],
            ['info_id' => 2, 'name' => 'Virtuales'],
            ['info_id' => 3, 'name' => 'Virtuales'],
            ['info_id' => 3, 'name' => 'Impresas'],
            ['info_id' => 4, 'name' => 'Volanteria'],
            ['info_id' => 4, 'name' => 'Tarjeta de precentación'],
            ['info_id' => 4, 'name' => 'Cotización Impresa (Marketing)'],
            ['info_id' => 5, 'name' => 'Decorativos'],
            ['info_id' => 5, 'name' => 'Uso practico'],

        ];
        \App\Models\TypeInfoDetail::insert($TypeInfoDetailList);



        // TYPO DE INFORMACION A CLIENTES
        $TypeInfoClientsList = [
            ['id' => 1, 'name' => 'Enviar catalogos'],
            ['id' => 2, 'name' => 'Enviar enviar recomendaciones'],
            ['id' => 3, 'name' => 'Enviar información general'],
            ['id' => 4, 'name' => 'El cliente nos enviara la información'],
        ];
        \App\Models\TypeInfoClient::insert($TypeInfoClientsList);


        // TYPO DE CONTACTO
        $TypeContact = [
            ['id' => 1, 'name' => 'Visita a Tienda'],
            ['id' => 2, 'name' => 'Vía telefónica'],
            ['id' => 3, 'name' => 'Mensaje de WhatsApp'],
            ['id' => 4, 'name' => 'Messenger'],
            ['id' => 5, 'name' => 'Correo electrónico'],
            ['id' => 6, 'name' => 'Mercado Libre'],
            ['id' => 7, 'name' => 'Pagina Web'],
            ['id' => 8, 'name' => 'Facebook'],
        ];
        \App\Models\TypeContact::insert($TypeContact);


        // TYPO DE COMPROMISO
        $TypeCompromise = [
            ['id' => 1, 'name' => 'Nota de venta'],
            ['id' => 2, 'name' => 'Cotización a distancia'],
            ['id' => 3, 'name' => 'Cotización a domicilio'],
            ['id' => 4, 'name' => 'Envio de información'],
        ];
        \App\Models\TypeCompromise::insert($TypeCompromise);


        // ESTADO DE COTIZACION
        $QuoteStatus = [
            ['id' => 1, 'name' => 'EN ESPERA'],
            ['id' => 2, 'name' => 'EN PROCESO'],
            ['id' => 3, 'name' => 'EN ESPERA DE VERIFICACION'],
            ['id' => 4, 'name' => 'CONFIMADA'],
            ['id' => 5, 'name' => 'RECHAZADA'],
            ['id' => 6, 'name' => 'FINALIZADA'],
        ];
        \App\Models\Quotes\QuoteStatus::insert($QuoteStatus);


        // CICLO DE ATENCION GLOBAL ESTADOS
        $CAGSt = [
            ['id' => 1, 'name' => 'EN ESPERA'],
            ['id' => 2, 'name' => 'EN CURSO'],
            ['id' => 3, 'name' => 'FINALIZADA'],
        ];
        \App\Models\CGlobal\CGlobalStatus::insert($CAGSt);


        // TYPO DE RECEPCION
        $TypeRecep = [
            ['id' => 1, 'name' => 'PRODUCTOS'],
            ['id' => 2, 'name' => 'HERRAMIENTAS'],
        ];
        \App\Models\Receptions\ReceptionType::insert($TypeRecep);


        // ESTADO DE LA RECEPCION
        $statusReceptionList = [
            ['id' => 1, 'name' => 'NO APLICADA'],
            ['id' => 2, 'name' => 'APLICADA'],
        ];
        \App\Models\Receptions\ReceptionStatus::insert($statusReceptionList);



        // ESTADO DE LA NOTAS DE VENTA
        $statusSalesList = [
            ['id' => 1, 'name' => 'RECIBIDO'],
            ['id' => 2, 'name' => 'PAGADA'],
        ];
        \App\Models\Quotes\QuoteStatus::insert($statusSalesList);


        // TIPOS DE VIA DE ENVIO DE INFORMACION
        $statusSendInfosList = [
            ['id' => 1, 'name' => 'Vía WhatsApp'],
            ['id' => 2, 'name' => 'Vía correo electrónico'],
            ['id' => 3, 'name' => 'Vía telefóno'],
            ['id' => 4, 'name' => 'Vía presencial'],
        ];
         \App\Models\TypeWaySendInfo::create($statusSendInfosList);



    }
}
