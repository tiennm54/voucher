@extends('email.master')
@section('content')
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">Refund For Order: #{{ $model_orders->order_no }}</td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    Dear {{ $model_orders->first_name." ".$model_orders->last_name }},
                                    <p>
                                        The amount you paid for the order #{{ $model_orders->order_no }} will be refunded <br/>
                                        Total refunded: ${{$model_orders->total_price}}. <br/>
                                        We will refund you within 24 hours.
                                    </p>
                                    <p>
                                        You can view your order history by going to the
                                        <a href="{{ URL::route('users.getMyAccount') }}">my account</a>
                                        page and by clicking on
                                        <a href="{{ URL::route('users.orderHistory') }}">history</a>.
                                        Thank you for using our service.
                                        We're so sorry about this inconvenient.
                                    </p>
                                    <p>
                                        <b>Best Regards</b>
                                        <p>Support Team BuyPremiumKey.Com</p>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@stop