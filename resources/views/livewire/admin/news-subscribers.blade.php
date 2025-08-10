<div>
    <div class="card-box pb-20 mb-4">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-auto table-sm table-condensed">
                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                </thead>
                <tbody>
                    @forelse ($subscribers as $subscriber)
                        <tr>
                            <td scope="row">#{{ $subscriber->id }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->created_at }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-center"><span class="text-danger">No slide item found!</span></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-block mt-1 text-center">
        {{ $subscribers->links('livewire::simple-bootstrap') }}
    </div>
</div>
