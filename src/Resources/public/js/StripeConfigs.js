class StripeConfigs {
    constructor(plan, test, successUrl, cancelUrl, orderId = null) {
        this._orderId = orderId;
        this._plan = plan;
        this._test = test;
        this._successUrl = successUrl;
        this._cancelUrl = cancelUrl;
    }

    get orderId() {
        return this._orderId;
    }

    get plan() {
        return this._plan;
    }

    get test() {
        return this._test;
    }

    get successUrl() {
        return this._successUrl;
    }

    get cancelUrl() {
        return this._cancelUrl;
    }

    set orderIdUrl(orderIdUrl) {
        this._orderIdUrl = orderIdUrl;
        return this;
    }

    get orderIdUrl() {
        return this._orderIdUrl;
    }
}