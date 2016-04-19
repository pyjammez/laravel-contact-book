<li class="list-group-item">
    <div class="col-xs-9 col-sm-9">
        <span class="name">{{ $contact->first_name }} {{ $contact->last_name }}</span><br>
        <table>
            <tbody>
                <tr>
                    <td style="width:20px;"><span class="fa fa-phone text-muted c-info"></span></td>
                    <td><span class="">{{ $contact->phone }}</span></td>
                </tr>
                <tr>
                    <td><span class="fa fa-envelope-o text-muted c-info"></span></td>
                    <td><span class="">{{ $contact->email }}</span><br></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">
                        @for ($i = 1; $i < 5; $i++)
                            @if (object_get($contact, "custom_{$i}") != '' )
                                <span class="fa fa-info-circle text-muted c-info"></span>
                                @break
                            @endif
                        @endfor
                    </td>
                    <td>
                        @for ($i = 1; $i < 6; $i++)
                            @if (object_get($contact, "custom_{$i}") != '' )
                                <span class="text-muted">{{ object_get($contact, "custom_{$i}") }}</span><br>
                            @endif
                        @endfor
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-xs-1 col-sm-1">
        <a id="edit_contact_button" onclick="editContact({{ $contact->id }})" title="Edit Contact" data-toggle="modal" data-target="#myModal">Edit</a>
    </div>
    <div class="col-xs-1 col-sm-1">
        <a id="delete_contact_button" onclick="deleteContact({{ $contact->id }})">Delete</a>
    </div>
    <div class="clearfix"></div>
</li>