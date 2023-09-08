export const $DisplayMoney = value => {
    return `$${value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
};

export const $ValidateEmail = email => {
    return String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
};
