<template>
    <div class="row"  v-cloak>
        <div class="row">
            <div class="col-lg-4">
                <span>Año</span>
                <select v-model="repMonth.year" class="form-control">
                    <option value="2018" selected>2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="col-lg-4">
                <span>Mes</span>
                <select v-model="repMonth.month" class="form-control">
                    <option v-for="month in meses" :value="month.id">@{{month.month}}</option>
                </select>
            </div>
            <div class="col-lg-2" style="margin-top: 20px">
                <div :class="runspinerAplic" @click="aplicar()">Aplicar<div class="ld ld-ring ld-spin"></div></div>
                <div :class="runspinerPdf" @click="pdfview_month(1)"><i class="fa fa-file-pdf-o"></i><div class="ld ld-ring ld-spin"></div></div>
                <div :class="runspinerfav" @click="pdfview_month(2)"><i class="fa fa-heart"></i><div class="ld ld-ring ld-spin"></div></div>
            </div>
            <div class="col-lg-2 text-right" style="margin-top: 20px">
                <button class="btn btn-default btn-sm" @click="close()">Cerrar</button>
            </div>
        </div>
        <div class="panel panel-border panel-inverse m-t-5">
            <div class="panel-heading"><h3>@{{ item.name }}</h3></div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Palabra</th>
                    <th>
                        <button class="btn btn-xs" :class="{'btn-facebook': orders_list.field === 'impres'}" @click="getdatasort('impres')">
                            Impresiones
                            <i v-if="orders_list.field === 'impres'" :class="{'fa fa-angle-up': orders_list.type === 'desc', 'fa fa-angle-down': orders_list.type === 'asc' }"></i>
                        </button></th>
                    <th> <button class="btn btn-xs" :class="{'btn-facebook': orders_list.field === 'middle'}" @click="getdatasort('middle')">
                        Posición
                        <i v-if="orders_list.field === 'middle'" :class="{'fa fa-angle-up': orders_list.type === 'desc', 'fa fa-angle-down': orders_list.type === 'asc' }"></i>

                    </button></th>
                    <th><button class="btn  btn-xs" :class="{'btn-facebook': orders_list.field === 'clics'}" @click="getdatasort('clics')">
                        Clics
                        <i v-if="orders_list.field === 'clics'" :class="{'fa fa-angle-up': orders_list.type === 'desc', 'fa fa-angle-down': orders_list.type === 'asc' }"></i>

                    </button></th>
                    <th><button class="btn  btn-xs" :class="{'btn-facebook':orders_list.field === 'volume'}" @click="getdatasort('volume')">
                        Volumen
                        <i v-if="orders_list.field === 'volume'" :class="{'fa fa-angle-up': orders_list.type === 'desc', 'fa fa-angle-down': orders_list.type === 'asc' }"></i>

                    </button></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="rep in month_list" :key="rep.id" >
                    <td >@{{rep.word}}</td>
                    <td> @{{rep.impres}} </td>
                    <td> @{{rep.middle}} </td>
                    <td> @{{rep.clics}} </td>
                    <td> @{{rep.volume}} </td>
                </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            <div class="panel-footer" style="padding: 2px 0 0 10px">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "reptilmonth"
    }
</script>

<style scoped>

</style>