<div>
    <div class="pd-20 card-box mb-30">
        <div class="table-responsive">
            <table class="table table-striped table-auto table-sm table-condensed">
                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                </thead>
                <tbody>
                    @forelse ($contactUs as $contact)
                        <tr>
                            <td scope="row">#{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->message }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-center"><span class="text-danger">No Contact us message
                                    found!</span></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-block mt-1">
            {{ $contactUs->links('livewire::simple-bootstrap') }}
        </div>
    </div>
</div>
