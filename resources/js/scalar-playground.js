import { createApiReference } from '@scalar/api-reference';
import '@scalar/api-reference/style.css';

const parseBoolean = (value, fallback = false) => {
    if (value === null || value === undefined || value === '') {
        return fallback;
    }

    return value === true || value === 'true' || value === '1';
};


const mountScalarApiReference = (target, options = {}) => {
    const element = typeof target === 'string' ? document.querySelector(target) : target;

    if (!element) {
        return;
    }

    createApiReference(element, options);
};

const mountFromDataset = () => {
    document.querySelectorAll('[data-scalar-playground]').forEach((element) => {
        const specUrl = element.getAttribute('data-spec-url');

        if (!specUrl) {
            return;
        }

        mountScalarApiReference(element, {
            url: specUrl,
            theme: element.getAttribute('data-theme') || 'light',
            hideModels: parseBoolean(element.getAttribute('data-hide-models'), true),
        });
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountFromDataset, { once: true });
} else {
    mountFromDataset();
}

window.ScalarPlayground = {
    mount: mountScalarApiReference,
};
