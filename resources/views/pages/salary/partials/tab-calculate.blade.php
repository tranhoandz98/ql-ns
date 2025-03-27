<div class="card-datatable table-responsive">
    <table class="table table-hover ">
        <thead>
            <tr>
                <th>
                    {{ __('messages.stt') }}
                </th>
                <th>
                    {{ __('messages.code') }}
                </th>
                <th>
                    {{ __('messages.salary-calculate-description') }}
                </th>
                <th>
                    {{ __('messages.salary-calculate-name') }}
                </th>
                <th class="text-end">
                    {{ __('messages.salary-calculate-total') }}
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($result->calculates as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $item->code }}
                    </td>
                    <td>
                        {{ $item->description }}
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td class="text-end">
                        @if ($item->code == 'TT' || $item->code == 'TL')
                            <input type="number" class="form-control text-end"
                            name="total-{{$index}}"
                            value={{ $item->total ?? 0 }} />
                        @else
                            {{ formatCurrency($item->total ?? 0) }}
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
