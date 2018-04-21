export const removeById = (items, id) => {
    items.splice(items.indexOf(
        items.find((item) => item.id === id)
    ), 1);
};
