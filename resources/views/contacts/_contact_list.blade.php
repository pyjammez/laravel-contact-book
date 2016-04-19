@forelse ($contacts as $contact)
    @include('contacts._contact', ['contact' => $contact])
@empty
<li>
    <p style="margin:0 15px;">No contacts<br /><br /></p>
</li>
@endforelse
