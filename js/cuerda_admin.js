const onlyNumbers = n => {
    return n.replace(/[０-９]/g, s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g, '');
};
