export const priceFormat = (value) => {
    let val = (value/1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

export const revertPriceFormat = (value) => {
    let pattern = /\./g;
    return value.replace(pattern, '');
}
