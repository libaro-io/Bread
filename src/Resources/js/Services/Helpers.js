const getPropByString = (obj, propString) => {
    if (!propString) {
        return obj;
    }

    let prop, props = propString.split('.');

    for (var i = 0, iLen = props.length - 1; i < iLen; i++) {
        prop = props[i];

        let candidate = obj[prop];
        if (candidate !== undefined && candidate !== null) {
            obj = candidate;
        } else {
            break;
        }
    }

    return obj[props[i]];
}

export { getPropByString }
