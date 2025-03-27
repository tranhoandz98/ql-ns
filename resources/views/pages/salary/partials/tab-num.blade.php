<div class="card-datatable table-responsive">

<table class="table table-hover ">
    <thead>
        <tr>
            <th>
                {{ __('messages.stt') }}
            </th>
            <th>
                {{ __('messages.salary-detail-name') }}
            </th>
            <th>
                {{ __('messages.code') }}
            </th>
             <th>
                {{ __('messages.salary-detail-num_day') }}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result->details as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $item?->name }}
                </td>
                <td>
                    {{ $item->code }}
                </td>
                <td >
                    {{ $item->num_day }}
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>