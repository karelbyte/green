<div class="input-group">
    <div v-if="fieldtype === 'select'" >
        <select v-model="filters_list.value" class="form-control">
            <option v-for="op in filters_list.options" :value="op.id">@{{ op.name }}</option>
        </select>
    </div>
    <input v-if="fieldtype !== 'select'" :type="fieldtype"  class="form-control" :placeholder="'Buscar por ' + filters_list.descrip " v-model="filters_list.value">
    <div class="input-group-btn">
        <button type="button" class="btn waves-effect waves-light btn-default dropdown-toggle" data-toggle="dropdown" style="overflow: hidden; position: relative;">@{{ filters_list.descrip }} <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li v-for="field in listfield"><a href="javascript:void(0)" @click="setfield(field)">@{{ field.name }}</a></li>
        </ul>
    </div>
</div>
