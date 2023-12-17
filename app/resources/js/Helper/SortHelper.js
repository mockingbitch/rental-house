export const sortArrayByPrice = (array) => {
    return array.sort((a, b) => a.price - b.price);
}

export const sortArrayByCapacity = (array) => {
    return array.sort((a, b) => a.capacity - b.capacity);
}
