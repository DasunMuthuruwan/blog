<div>
    <div class="pd-20 card-box mb-30">
        <div class="table-responsive">
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
                            <td colspan="8" class="text-center"><span class="text-danger">No news subscriber
                                    found!</span></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-block mt-1">
            {{ $subscribers->links('livewire::simple-bootstrap') }}
        </div>
    </div>
</div>
