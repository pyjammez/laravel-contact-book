
<style>
    li{list-style:none;}
    form {margin:20px;}
    #add_custom_field {cursor:pointer;text-decoration:underline;}
    .remove_custom_field {cursor:pointer;float:right;margin: -28px 26px 0 0;}
</style>

<div class="row">
    <div class="col-xs-12">
        
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($contact->id))
            {!! Form::model($contact, ['route' => ['contacts.update', $contact->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::model($contact, ['route' => ['contacts.store'], 'class' => 'form-horizontal']) !!}
        @endif
        
        <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', 'First Name', array('class' => 'col-md-3 control-label')) !!}
            <div class="input-group col-md-8">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {!! Form::text('first_name', null, array('class' => 'form-control', 'placeholder'=>'First Name')) !!}
            </div>
        </div>
        
        <div class="form-group  {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', 'Last Name', array('class' => 'col-md-3 control-label')) !!}
            <div class="input-group col-md-8">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {!! Form::text('last_name', null, array('class' => 'form-control', 'placeholder'=>'Last Name')) !!}
            </div>
        </div>
        
        <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}
            <div class="input-group col-md-8">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {!! Form::text('email', null, array('class' => 'form-control', 'placeholder'=>'Email')) !!}
            </div>
        </div>
        
        <div class="form-group  {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', 'Phone', array('class' => 'col-md-3 control-label')) !!}
            <div class="input-group col-md-8">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder'=>'Phone')) !!}
            </div>
        </div>
        
        @for ($i = 1; $i < 6; $i++)
            <div style="display:{{ !$contact->{'custom_'.$i} && $i!=1 ? 'none' : '' }}" class="custom_field_box form-group {{ $errors->has('custom_{$i}') ? 'has-error' : '' }}">
                @if ($i == 1)
                    {!! Form::label("custom_{$i}", 'Custom Field', array('class' => 'col-md-3 control-label')) !!}
                @else 
                    <label class='col-md-3'></label>
                @endif
                <div class="input-group col-md-8">
                    <span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
                    {!! Form::text('custom_'.$i, null, array('class' => 'form-control')) !!}
                </div>
                @if ($i != 1)
                <a onclick="removeCustomField()" class="remove_custom_field" title="Remove Field">
                    <i class="fa fa-times"></i>
                </a>
                @endif
            </div>
        @endfor
        
        <div class="form-group">
            <label class='col-md-3'></label>
            <div class="input-group col-md-8">
                <a onclick="addCustomField(this)" id="add_custom_field">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
            
        {!! Form::close() !!}
        
    </div>
</div>

<script>
    function addCustomField(el) {
        var custom_field_boxes = $('.custom_field_box:hidden');
        $('.remove_custom_field').hide();
        custom_field_boxes.first().show().find('.remove_custom_field').show();
        if (custom_field_boxes.length == 1) $(el).hide();
    }

    function removeCustomField() {
        $('.custom_field_box:visible').last().val('').hide().prev().find('.remove_custom_field').show();;
        $('#add_custom_field').show();
    }
</script>
