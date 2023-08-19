class StripeClient {
    constructor(stripeConfigs, styleConfigs = null) {
        this.stripe_url = '/payment-client/stripe';
        this._configs = stripeConfigs;
        this._styleConfigs = styleConfigs;
    }

    getForm(stripeDiv, formName, locale = null) {
        if (!this._configs instanceof StripeConfigs) {
            return false;
        }
        let data = new FormData();
        if (this._configs.orderId !== null) {
            data.append('order_id', this._configs.orderId);
        } else {
            data.append('order_id_url', this._configs.orderIdUrl);
        }
        data.append('plan', this._configs.plan);
        data.append('stripe_test', this._configs.test);
        data.append('success_url', this._configs.successUrl);
        data.append('cancel_url', this._configs.cancelUrl);
        data.append('form_name', formName);
        let html = '';
        let url = this.stripe_url + '/get-form';
        if (locale !== null) {
            url = '/' + locale + url;
        }
        $.ajax({
            url: url,
            async: false,
            method: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                $(stripeDiv).html(response);
            }
        });
        this._configureStyle(formName);
        $('.stripe-btn').click(function () {
            let formName = $(this).data('form');
            if ($(`#${formName} > input[name="order_id_url"]`).length !== 0) {
                let url = $(`#${formName} > input[name="order_id_url"]`).val();
                if ($(`#${formName} > input[name="order_id"]`).length === 0) {
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'order_id')
                        .val(StripeClient.getOrderId(url))
                        .appendTo(`#${formName}`);
                }
            }
            $(`#${formName}`).submit();
        });
    }

    _configureStyle(formName) {
        if (this._styleConfigs != null && this._styleConfigs instanceof StripeStyleConfig) {
            if (this._styleConfigs.padding !== null) {
                $('.stripe-btn').css('padding', this._styleConfigs.padding);
            }
            if (this._styleConfigs.borderRadius != null) {
                $('.stripe-btn').css('border-radius', this._styleConfigs.borderRadius);
            }
            if (this._styleConfigs.btnText != null) {
                $(`#stripe-btn-text[data-form="${formName}"]`).html(this._styleConfigs.btnText);
            }
            if (this._styleConfigs.useIcon === false) {
                $('#stripe-icon').css('display', 'none');
            }
            if (this._styleConfigs.btnClass != null) {
                $('.stripe-btn').removeClass('stripe-btn-default').addClass(this._styleConfigs.btnClass);
            }
        }
    }

    static getOrderId(url) {
        let orderId = undefined;
        $.ajax({
            url: url,
            async: false,
            method: 'get',
            success: function (response) {
                orderId = response.order.order_id;
            }
        });
        return orderId;
    }
}
