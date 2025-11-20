export function createSvgIcon(path, classes = '') {
    return `<svg xmlns='http://www.w3.org/2000/svg' class='${classes}' viewBox='0 0 24 24' fill='currentColor'><path d='${path}'/></svg>`;
}
