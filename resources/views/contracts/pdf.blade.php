<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Enquiry PDF</title>
</head>

<body>
    <h3>Welcome to Weigh-Till.co.uk - Enquiry No:{{ $enquiry->id }}</h3>

    <h5>Customer: - {{ $enquiry->enq_customer }}</h5>
    <h6>Description</h6>
    <p>{{$enquiry->enq_description}}</p>
    <h6>Contact Details</h6>
    <table class="table table-hover">
        <thead>
            <tr>

                <td>Email</td>
                <td>Phone</td>


            </tr>
        </thead>

        <tr>


            <td>
                {{$enquiry->enq_email}}
            </td>
            <td>
                {{$enquiry->enq_phone}}
            </td>
        </tr>

    </table>
</body>

</html>