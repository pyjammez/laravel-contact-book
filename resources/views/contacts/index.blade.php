@extends('layouts.app')

@section('content')
<style>
    li{list-style:none;}
    .c-search {margin:15px;}
    #edit_contact_button {text-decoration:underline;cursor:pointer;}
    #delete_contact_button {text-decoration:underline;cursor:pointer;}
    .c-controls a {cursor:pointer;}
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading c-list">
                    <span class="title">Contacts</span>
                    <ul class="pull-right c-controls">
                        <li>
                            <a onclick="addContact()" title="Add Contact" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                        
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group c-search">
                            <input type="text" onkeyup="searchContacts(this.value)" class="form-control" id="contact-list-search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span class="fa fa-search text-muted"></span></button>
                            </span>
                        </div>
                    </div>
                </div>
                        
                <ul class="list-group" id="contact-list">
                    @include('contacts._contact_list', ['contacts' => $contacts])
                </ul>
            </div>
        </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content panel-default">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="saveContact()" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
function addContact() {
    $('.modal-title').html('Add Contact');
    $('.modal-body').load('/contacts/create');    
}

function editContact(id) {
    $('.modal-title').html('Edit Contact');
    $('.modal-body').load('/contacts/' + id + '/edit');
}

function deleteContact(id) {
    $.ajax({
        method: 'POST',
        url: '/contacts/' + id,
        dataType: 'json',
        data: {_method: 'delete'}
    }).done(function(response) {
        $('#contact-list').load('contacts');
    });
}

function saveContact() {
    var form = $(".modal form");
    $.ajax({
        method: 'POST',
        url: form.attr('action'),
        dataType: 'json',
        data: form.serialize()
    }).done(function(response) {
        $('#myModal').modal('hide');
        $('#contact-list').load('contacts');
    });
}

function searchContacts(query) {
    if (query.length > 1 || !query.length) {
        $('#contact-list').load('contacts?query=' + encodeURIComponent(query));
    }
}
</script>
@endsection
