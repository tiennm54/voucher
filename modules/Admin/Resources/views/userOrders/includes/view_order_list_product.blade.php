<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td class="text-left">Product Image</td>
                <td class="text-left">Product Name</td>
                <td class="text-right">Quantity</td>
                <td class="text-center">Premium key</td>
                <td class="text-right">Price</td>
                <td class="text-right">Total</td>

            </tr>
        </thead>
        <?php if (count($model->orders_detail) == 0): ?>
            <tbody>
                <tr>
                    <td class="text-left" colspan="6">Your shopping cart is empty!</td>
                </tr>
            </tbody>
        <?php endif; ?>
        <?php if (count($model->orders_detail) > 0): ?>
            <?php foreach ($model->orders_detail as $item): ?>
                <tbody>
                    <tr>
                        <td class="text-left">
                            <a href="{{ $item->articles_type->getArticles->reseller_page }}" target="_blank">
                                <img src="{{ $item->articles_type->getArticles->getImage() }}" style="width: 200px"/>
                            </a>
                        </td>
                        <td class="text-left">
                            <a href="{{ $item->articles_type->getUrl() }}" target="_blank">
                                {{ $item->articles_type->title }}
                            </a>
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-center">
                            <a href="{{URL::route('adminUserOrders.getAddPremiumKey',[ 'product_id' => $item->articles_type->id, 'order_detail_id' => $item->id ])}}" 
                               class="btn {{ ($item->count_key == $item->quantity) ? "btn-primary" : "btn-danger"}}">
                                Đã add {{ $item->count_key }} key
                            </a>
                        </td>

                        <td class="text-right">${{ $item->price_order }}</td>
                        <td class="text-right">${{ $item->total_price }}</td>

                    </tr>
                </tbody>
            <?php endforeach; ?>
        <?php endif; ?>

        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td class="text-right"><b>Sub-Total</b></td>
                <td class="text-right">${{ $model->sub_total }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right"><b>Chargers {{ $model->payment_type->title }}</b></td>
                <td class="text-right">${{ $model->payment_charges }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right"><b>Used bonus</b></td>
                <td class="text-right" style="vertical-align: middle">
                    <span class="label {{ ($model->used_bonus == 0) ? "label-success" : "label-danger"}}">${{ $model->used_bonus }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="4"></td>
                <td class="text-right"><b>Total</b></td>
                <td class="text-right">${{ $model->total_price }}</td>
            </tr>

            <tr>
                <td colspan="4"></td>
                <td class="text-right"><b>Thực nhận</b></td>
                <td class="text-right">${{ ($model->total_price - (($model->total_price * RATE_PAYPAL)/100 + 0.3)) }}</td>
            </tr>

        </tfoot>

    </table>
</div>