document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.prisa pre code');
    blocks.forEach((codeEl) => {
        const raw = codeEl.textContent.replace(/\s+$/, '');
        const lines = raw.split('\n');

        // Ambil bahasa dari class `language-xxx` atau data-lang
        let lang = codeEl.dataset.lang || '';
        if (!lang) {
            const cls = [...codeEl.classList].find(c => c.startsWith('language-'));
            lang = cls ? cls.replace('language-', '') : 'code';
        }

        // Bangun markup baru
        const wrapper = document.createElement('div');
        wrapper.className = 'prisa-code';

        const langBadge = document.createElement('div');
        langBadge.className = 'prisa-lang';
        langBadge.textContent = lang.toUpperCase();

        const copyBtn = document.createElement('button');
        copyBtn.type = 'button';
        copyBtn.className = 'prisa-copy';
        copyBtn.textContent = 'Copy';

        const linesWrapper = document.createElement('div');
        linesWrapper.className = 'prisa-lines';

        const gutter = document.createElement('div');
        gutter.className = 'prisa-gutter';

        const codeLines = document.createElement('div');
        codeLines.className = 'prisa-code-lines';

        lines.forEach((line, idx) => {
            const ln = document.createElement('span');
            ln.className = 'prisa-line';
            ln.textContent = idx + 1;
            gutter.appendChild(ln);

            const cl = document.createElement('span');
            cl.className = 'prisa-line';
            cl.textContent = line === '' ? ' ' : line;
            codeLines.appendChild(cl);
        });

        linesWrapper.appendChild(gutter);
        linesWrapper.appendChild(codeLines);

        const pre = document.createElement('pre');
        pre.appendChild(linesWrapper);

        wrapper.appendChild(langBadge);
        wrapper.appendChild(copyBtn);
        wrapper.appendChild(pre);

        // Replace code block
        const parentPre = codeEl.parentElement;
        parentPre.replaceWith(wrapper);

        // Copy handler
        copyBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(raw);
                copyBtn.textContent = 'Copied';
                copyBtn.classList.add('copied');
                setTimeout(() => {
                    copyBtn.textContent = 'Copy';
                    copyBtn.classList.remove('copied');
                }, 1200);
            } catch (e) {
                console.error('Copy failed', e);
            }
        });
    });

    // Wrap tabel dalam container agar scroll horizontal tidak meluber
    document.querySelectorAll('.prisa table').forEach((table) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'prisa-table-wrap';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
});
