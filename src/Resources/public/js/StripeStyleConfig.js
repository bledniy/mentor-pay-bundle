class StripeStyleConfig {
    constructor() {
        this._useIcon = true;
    }

    set padding(padding) {
        this._padding = padding;
        return this;
    }

    get padding() {
        return this._padding;
    }

    set borderRadius(borderRadius) {
        this._borderRadius = borderRadius;
        return this;
    }

    get borderRadius() {
        return this._borderRadius;
    }

    set btnText(btnText) {
        this._btnText = btnText;
        return this;
    }

    get btnText() {
        return this._btnText;
    }

    set useIcon(useIcon) {
        this._useIcon = useIcon;
        return this;
    }

    get useIcon() {
        return this._useIcon;
    }

    set btnClass(btnClass) {
        this._btnClass = btnClass;
    }

    get btnClass() {
        return this._btnClass;
    }
}