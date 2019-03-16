<div id="modaldelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Eliminar</h3>
                    </div>
                    <div class="panel-body">
                        <p>Elemento: <samp class="txtblack">@{{delobj}}</samp> </p>
                        <p>Cuidado! Esta acción es irreversible. Desea proceder?</p>
                    </div>
                    <div class="panel-footer text-right">
                        <button @click="delitem()" class="btn btn-danger waves-effect btn-sm">SI</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
