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

  const ObjectByString = function(o, s) {
      s = s.replace(/\[(\w+)\]/g, '.$1'); // convert indexes to properties
      s = s.replace(/^\./, '');           // strip a leading dot
      var a = s.split('.');
      for (var i = 0, n = a.length; i < n; ++i) {
          var k = a[i];
          if (k in o) {
              o = o[k];
          } else {
              return;
          }
      }
      return o;
  }

export { getPropByString, ObjectByString }
