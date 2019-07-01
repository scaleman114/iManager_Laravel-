@extends('repairs.pdflayout')

@section('content')
<div>
    <table class="table table-bordered">
        <tr>
            <td>
                <h6>Customer:</h6>
            </td>
            <td colspan="2">
                <h6>Details:</h6>
            </td>
        </tr>

        <tr>
            <td>

                {!! nl2br(e($address)) !!}


            </td>

            <td style="text-align:right">

                Repair No:<br>
                Date:<br>
                Min. Charge:<br>
                Quoted:<br>
                Hours:
            </td>

            <td>

                {{ $repair->id }}<br>
                {{ date('d/m/y',strtotime($repair->date)) }}<br>
                {{ $repair->min_charge }}<br>
                {{ $repair->quoted }}<br>
                {{ $repair->hours }}
            </td>


        </tr>
        <tr>
            <td colspan="3">
                <h6>Description:</h6>
                <p>{{$repair->notes}}</p>
            </td>
        </tr>




    </table>
</div>

<table class="table table-bordered">

    <tr>
        <td colspan="3">
            <h6>Item Details:</h6>
        </td>
    </tr>

    <thead>
        <tr>
            <td>Machine</td>
            <td>Serial No.</td>
            <td>Capacity</td>
        </tr>
    </thead>




    @foreach($repairitems as $items)
    <tr>

        <td>{{ $items->mc_type }}</td>
        <td>{{ $items->serial_no }}</td>
        <td>{{ $items->capacity }}</td>
    </tr>
    @endforeach

</table>

<div class="signaturestrip">
    <table>

        <tr>
            <td colspan="2">
                <p>
                    Engineer_____________________________________________
                </p>
            </td>



        </tr>
        <tr>
            <td>
                <p>I/We accept Weigh-Till T & Cs (available on request)<br><br>
                    Customer_____________________________________________
                </p>
            </td>

            <td>
                <p style="font-size:50%;">In the case of an electrical product repair we cannot guarantee that other
                    faults
                    will not develop within the 3 month warranty period. Electrical appliances are instruments
                    containing nmany components and within the repair the parts specified have been replaced.
                    The breakdown of other parts may cause a fault similar to the fault prior to the repair.</p>

            </td>


        </tr>

    </table>
</div>

@endsection