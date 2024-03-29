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
        // ROL ADMINISTRADOR

        $role = \Spatie\Permission\Models\Role::create([

            'name' => 'administrador',
            'guard_name' => 'web'
        ]);

        $permission = \Spatie\Permission\Models\Permission::query()->select('name')->get();

        $role->givePermissionTo($permission->pluck('name'));

        // Creando usuario
        $user = \App\Models\Users\User::create([
            'name' => 'Administrador',
            'email' => 'admin@gc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('gc12345*-'),
            'active_id' => 1,
            'position_id' => 1
        ]);

        $user->assignRole('administrador');


       // ESTADO DE USUARIOS
       $statusUserList = [
            ['id' => 0, 'name' => 'Inactivo'],
            ['id' => 1, 'name' => 'Activo'],
        ];
        \App\Models\Users\UserStatus::insert($statusUserList);


        // POSICION DEL PERSONAL
        $UserPositionList = [
            ['id' => 1, 'name' => 'Administración'],
            ['id' => 2, 'name' => 'Acesor de Jardin'],
            ['id' => 3, 'name' => 'Paisajista'],
        ];
        \App\Models\Users\UserPosition::insert($UserPositionList);



        // TYPO DE INFORMACION
        $TypeInfoList = [
            ['id' => 1, 'name' => 'Cotización'],
            ['id' => 2, 'name' => 'Catalogo'],
            ['id' => 3, 'name' => 'Imagenes'],
            ['id' => 4, 'name' => 'Publicidad'],
            ['id' => 5, 'name' => 'Productos'],
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
            ['id' => 9, 'name' => 'BNI Interno'],
            ['id' => 10, 'name' => 'BNI Externo'],
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
            ['id' => 1, 'name' => 'VISITA POR REALIZAR'],
            ['id' => 2, 'name' => 'EN PROCESO'],
            ['id' => 3, 'name' => 'EN ESPERA DE VERIFICACION'],
            ['id' => 4, 'name' => 'CONFIMADA - ACEPTADA'],
            ['id' => 5, 'name' => 'CONFIRMADA - NO ACEPTADA'],
            ['id' => 6, 'name' => 'CONFIRMADA - MODIFICAR'],
            ['id' => 7, 'name' => 'SEGIMIENTO'],
            ['id' => 8, 'name' => 'ESTRATEGIA DE VENTA'],
            ['id' => 9, 'name' => 'CONFIRMAR E.VENTA'],
            ['id' => 10, 'name' => 'VISITADO'],
            ['id' => 11, 'name' => 'CONTIZANDO'],
        ];
        \App\Models\Quotes\QuoteStatus::insert($QuoteStatus);


        // CICLO DE ATENCION GLOBAL ESTADOS
        $CAGSt = [
            ['id' => 1, 'name' => 'VISITA POR REALIZAR'],
            ['id' => 2, 'name' => 'ELABORANDO NOTA'],
            ['id' => 3, 'name' => 'EN PROCESO DE VENTA'],
            ['id' => 4, 'name' => 'VENTA'],
            ['id' => 5, 'name' => 'FINALIZADA - NO VENTA'],
            ['id' => 6, 'name' => 'EN EJECUCION'],
            ['id' => 7, 'name' => 'RECOMENDACIONES'],
            ['id' => 8, 'name' => 'VISITA A DOMICILIO'],
            ['id' => 9, 'name' => 'COTIZADO'],
            ['id' => 10, 'name' => 'CONFIRMANDO COTIZACION'],
            ['id' => 11, 'name' => 'SEGUIMIENTO DE COTIZACION'],
            ['id' => 12, 'name' => 'ESTRATEGIA DE VENTA'],
            ['id' => 13, 'name' => 'CONFIRMAR E.VENTA'],
            ['id' => 14, 'name' => 'SE ENVIO RECOMENDACIONES'],
            ['id' => 15, 'name' => 'CONCLUIDO'],
            ['id' => 16, 'name' => 'SE ENVIARA INFORMACION'],
            ['id' => 17, 'name' => 'SE ENVIO INFORMACION'],
            ['id' => 18, 'name' => 'INFORMACION CONFIRMADA'],
        ];
        \App\Models\CGlobal\CGlobalStatus::query()->insert($CAGSt);


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
            ['id' => 3, 'name' => 'EN PROCESO'],
            ['id' => 4, 'name' => 'RECIBIDO - EN EJECUCION'],
            ['id' => 5, 'name' => 'PAGADA - EN EJECUCION'],
            ['id' => 6, 'name' => 'EN EJECUCION'],
            ['id' => 7, 'name' => 'PAGADA - TERMINADA'],
            ['id' => 8, 'name' => 'RECIBIDO - TERMINADA'],
            ['id' => 9, 'name' => 'TERMINADA'],
        ];
        \App\Models\SalesNotes\SalesNoteStatus::insert($statusSalesList);


        // TIPOS DE VIA DE ENVIO DE INFORMACION
        $statusSendInfosList = [
            ['id' => 1, 'name' => 'Vía WhatsApp'],
            ['id' => 2, 'name' => 'Vía correo electrónico'],
            ['id' => 3, 'name' => 'Vía telefóno'],
            ['id' => 4, 'name' => 'Vía presencial'],
            ['id' => 5, 'name' => 'Visita a cliente']
        ];
         \App\Models\TypeWaySendInfo::insert($statusSendInfosList);

        \App\Models\Measure::create(['id' => 1, 'name' => 'PIEZA.']);


        // ESTADO DE MANTENIMIENTO
       $statusManteList = [
           ['id' => 0, 'name' => 'Inactivo'],
           ['id' => 1, 'name' => 'Activo'],
       ];
        \App\Models\Maintenances\MaintenanceStatus::insert($statusManteList);

        // ESTADO DE MANTENIMIENTO  DETALLE
        $statusManteDetailList = [
            ['id' => 1, 'name' => 'EN ESPERA'],
            ['id' => 2, 'name' => 'EN PROCESO'],
            ['id' => 3, 'name' => 'EN EJECUCION'],
            ['id' => 4, 'name' => 'TERMINADO'],
            ['id' => 5, 'name' => 'TERMINADO - PAGADO'],
            ['id' => 6, 'name' => 'TERMINADO-RECOMENDACIONES'],
            ['id' => 7, 'name' => 'CANCELADO'],
        ];
        \App\Models\Maintenances\MaintenaceStatusDetail::insert($statusManteDetailList);

        $statusQualitiesList = [
            ['id' => 1, 'name' => 'EN ESPERA'],
            ['id' => 2, 'name' => 'EN ENVIADA'],
            ['id' => 3, 'name' => 'CONFIRMADA'],
            ['id' => 4, 'name' => 'FINALIZADA']
        ];

        \App\Models\Qualities\QualityStatus::query()->insert($statusQualitiesList);

    }
}
