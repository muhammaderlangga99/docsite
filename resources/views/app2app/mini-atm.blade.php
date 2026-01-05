@extends('layout.dashboard')

@section('title', 'App2App Mini ATM')

@section('dashboard-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">App2App</p>
        <h1 class="text-2xl font-semibold text-slate-900">Mini ATM</h1>
        <p class="text-sm text-slate-500 mt-1">Credential data for the signed-in user.</p>
    </div>
</div>

<div class="mt-8 space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-900">URI Scheme Param</h2>
        <p class="text-sm text-slate-600 mt-1">Berikut ini adalah URI Scheme untuk perintah permintaan payment request ke aplikasi Cashlez dari aplikasi merchant.</p>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white">
        <h3 class="text-sm font-semibold text-slate-800 mb-2">Action Name</h3>
        <ul class="text-sm text-slate-700 space-y-1">
            <li>Cek Saldo: <code class="px-1 py-0.5 rounded bg-slate-100">checkbalance</code></li>
            <li>Transfer: <code class="px-1 py-0.5 rounded bg-slate-100">transfer</code></li>
            <li>Tarik Tunai: <code class="px-1 py-0.5 rounded bg-slate-100">cashwithdrawal</code></li>
        </ul>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white">
        <h3 class="text-sm font-semibold text-slate-800 mb-3">Contoh membangun URI untuk pindah aplikasi (Java)</h3>
        <div class="code-window">
            <div class="code-dots">
                <span class="code-dot code-dot-red"></span>
                <span class="code-dot code-dot-amber"></span>
                <span class="code-dot code-dot-emerald"></span>
            </div>
            <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">public void attemptRequestNg(ActionName actionName) {
  Intent intent = new Intent();
  StringBuilder sbUri = new StringBuilder();
  sbUri.append("cashlez://miniatm");
  sbUri.append(ACTION_NAME);
  sbUri.append("?launcher=");
  sbUri.append(data.isLauncher());
  sbUri.append("&amp;amount=");
  sbUri.append(data.getAmount());
  sbUri.append("&amp;callback=");
  sbUri.append(data.getCallback());
  if (actionName.equals(ActionName.Action_Transfer)){
    sbUri.append("&amp;beneBankCode=");
    sbUri.append(data.getBeneBankCode());
    sbUri.append("&amp;beneAccountNo=");
    sbUri.append(data.getBeneAccountNo());
  }
  /* sample additional query string */
  sbUri.append("&amp;customerRefNo=BL123456");
  sbUri.append("&amp;csr=BL654321");
  String strUri = sbUri.toString();
  intent.setAction("android.intent.action.VIEW");
  intent.setData(Uri.parse(strUri));
  nextLauncher.launch(intent);
}</code></pre>
        </div>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white">
        <h3 class="text-sm font-semibold text-slate-800 mb-3">Contoh request Jump App (Kotlin)</h3>
        <div class="code-window">
            <div class="code-dots">
                <span class="code-dot code-dot-red"></span>
                <span class="code-dot code-dot-amber"></span>
                <span class="code-dot code-dot-emerald"></span>
            </div>
            <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">val btnCb: Button = findViewById(R.id.btnCb)
btnCb.setOnClickListener {
    jumpApp.withData(data).checkBalance()
}

val btnTf: Button = findViewById(R.id.btnTf)
btnTf.setOnClickListener {
    data.amount = getRandomAmount()
    data.beneBankCode = "008"
    data.beneAccountNo = "15500088992"
    jumpApp.withData(data).transfer()
}

val btnWd: Button = findViewById(R.id.btnWd)
btnWd.setOnClickListener {
    data.amount = getRandomAmount()
    jumpApp.withData(data).cashWithdraw()
}</code></pre>
        </div>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white">
        <h3 class="text-sm font-semibold text-slate-800 mb-3">Class JumApp.java</h3>
        <div class="code-window">
            <div class="code-dots">
                <span class="code-dot code-dot-red"></span>
                <span class="code-dot code-dot-amber"></span>
                <span class="code-dot code-dot-emerald"></span>
            </div>
            <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">public class JumApp {
    private static JumpBuilder jumpBuilder;
    public static JumApp initJumpApp(JumpListener listener, AppCompatActivity activity){
        if (jumpBuilder == null){
            jumpBuilder = new JumpBuilder();
        }
        jumpBuilder.initJumpApp(activity);
        jumpBuilder.setListener(listener);
        return jumpBuilder.jumApp;
    }

    public JumApp withData(MiniAtmRequest data){
        if (jumpBuilder == null){
            jumpBuilder = new JumpBuilder();
        }
        jumpBuilder.setData(data);
        return jumpBuilder.jumApp;
    }

    public void checkBalance(){
        jumpBuilder.attemptRequestNg(ActionName.Action_Check_Balance);
    }

    public void transfer(){
        jumpBuilder.attemptRequestNg(ActionName.Action_Transfer);
    }

    public void cashWithdraw(){
        jumpBuilder.attemptRequestNg(ActionName.Action_Cash_Withdrawal);
    }

    private static class JumpBuilder {
        private JumApp jumApp;
        private AppCompatActivity activity;
        private MiniAtmRequest data;
        private JumpListener listener;
        private ActivityResultLauncher&lt;Intent&gt; nextLauncher;

        public void initJumpApp(AppCompatActivity activity){
            jumApp = new JumApp();
            this.activity = activity;
            nextLauncher = activity.registerForActivityResult(new ActivityResultContracts.StartActivityForResult(), result -> {
                if (result.getResultCode() == RESULT_OK){
                    listener.onRawResult(result.getData());
                } else {
                    listener.onCancel();
                }
            });
        }

        public void setData(MiniAtmRequest data) {
            this.data = data;
        }

        public void setListener(JumpListener listener){
            this.listener = listener;
        }

        public void attemptRequestNg(ActionName actionName) {
            Intent intent = new Intent();
            StringBuilder sbUri = new StringBuilder();
            sbUri.append("cashlez://miniatm.");
            sbUri.append(actionName.getName());
            sbUri.append("?launcher=");
            sbUri.append(data.isLauncher());
            sbUri.append("&amp;amount=");
            sbUri.append(data.getAmount());
            sbUri.append("&amp;callback=");
            sbUri.append(data.getCallback());
            if (actionName.equals(ActionName.Action_Transfer)){
                sbUri.append("&amp;beneBankCode=");
                sbUri.append(data.getBeneBankCode());
                sbUri.append("&amp;beneAccountNo=");
                sbUri.append(data.getBeneAccountNo());
            }
            String strUri = sbUri.toString();
            intent.setAction("android.intent.action.VIEW");
            intent.setData(Uri.parse(strUri));
            nextLauncher.launch(intent);
        }
    }

    public interface JumpListener {
        void onRawResult(Intent result);
        void onCancel();
    }
}</code></pre>
        </div>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-slate-800 mb-2">Payment Callback</h3>
            <p class="text-sm text-slate-600">Callback dapat di-handle dengan cara berikut:</p>
        </div>
        <div class="code-window">
            <div class="code-dots">
                <span class="code-dot code-dot-red"></span>
                <span class="code-dot code-dot-amber"></span>
                <span class="code-dot code-dot-emerald"></span>
            </div>
            <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">public void initJumpApp(AppCompatActivity activity){
    jumApp = new JumApp();
    this.activity = activity;

    nextLauncher = activity.registerForActivityResult(new ActivityResultContracts.StartActivityForResult(), result -> {
        Log.e("TAG", "initJumpApp: " + result.toString() );
        if (result.getResultCode() == RESULT_OK){
            Log.e("TAG", "initJumpApp: " + result.getData() );
            listener.onRawResult(result.getData());
        } else {
            listener.onCancel();
        }
    });
}</code></pre>
        </div>
        <div class="code-window">
            <div class="code-dots">
                <span class="code-dot code-dot-red"></span>
                <span class="code-dot code-dot-amber"></span>
                <span class="code-dot code-dot-emerald"></span>
            </div>
            <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">override fun onRawResult(result: Intent) {
    val rawResult = uriToHashMap(result.data)
    Log.i("TAG", "onRawResult: $rawResult")
    updateResult(rawResult.toString(), "onRawResult")
}</code></pre>
        </div>
    </div>

    <div class="border border-slate-200 rounded-xl p-5 bg-white space-y-4">
        <h3 class="text-sm font-semibold text-slate-800">Contoh lampiran log respon</h3>
        <div>
            <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-2">Check balance</p>
            <div class="code-window">
                <div class="code-dots">
                    <span class="code-dot code-dot-red"></span>
                    <span class="code-dot code-dot-amber"></span>
                    <span class="code-dot code-dot-emerald"></span>
                </div>
                <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">onRawResult: {approvalCode=173787607993, maskedPan=4889********2538, typeSavings=Tabungan, traceNo=000693, type=balance, respCode=00, status=Success}</code></pre>
            </div>
        </div>
        <div>
            <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-2">Transfer</p>
            <div class="code-window">
                <div class="code-dots">
                    <span class="code-dot code-dot-red"></span>
                    <span class="code-dot code-dot-amber"></span>
                    <span class="code-dot code-dot-emerald"></span>
                </div>
                <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">onRawResult: {receiverAccountName=IQBAL RIZKY RAMDHAN, approvalCode=173787618762, maskedPan=4889********2538, senderBankName=Bank Jago, typeSavings=Tabungan, traceNo=000848, receiverBankName=PT. BANK MANDIRI, TBK., senderAccountName=NOVILANTI NUR, type=transfer, respCode=00, receiverAccount=15500088992, status=Success}</code></pre>
            </div>
        </div>
        <div>
            <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-2">Withdrawal</p>
            <div class="code-window">
                <div class="code-dots">
                    <span class="code-dot code-dot-red"></span>
                    <span class="code-dot code-dot-amber"></span>
                    <span class="code-dot code-dot-emerald"></span>
                </div>
                <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code class="code-highlight">onRawResult: {approvalCode=173787626225, maskedPan=4889********2538, senderBankName=Bank Jago, typeSavings=Tabungan, traceNo=000850, senderAccountName=TRI WALIANGGA, type=withdraw, respCode=00, status=Success}</code></pre>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .code-window {
        background: #0b1020;
        border: 1px solid #1f2437;
        border-radius: 12px;
        padding: 16px;
        overflow: hidden;
        color: #e5e7eb;
    }
    .code-dots {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
    }
    .code-dot {
        width: 12px;
        height: 12px;
        border-radius: 9999px;
        display: inline-block;
    }
    .code-dot-red { background: #ff6b6b; }
    .code-dot-amber { background: #f7b955; }
    .code-dot-emerald { background: #50d890; }
    .code-keyword { color: #f3a952; }
    .code-type { color: #fb7b55; }
    .code-string { color: #7ee787; }
    .code-number { color: #a5d6ff; }
    .code-comment { color: #94a3b8; }
    .code-builtin { color: #60a5fa; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.copy-btn').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const value = btn.dataset.copy;
                if (!value) return;
                try {
                    await navigator.clipboard.writeText(value);
                    const previous = btn.textContent;
                    btn.textContent = 'Copied';
                    setTimeout(() => { btn.textContent = previous; }, 1200);
                } catch (err) {
                    console.error('Copy failed', err);
                }
            });
        });

        const keywordRegex = /\b(override|fun|val|var|public|private|class|static|void|new|return|if|else|for|while|try|catch)\b/g;
        const typeRegex = /\b(Intent|StringBuilder|Uri|Toast|Log|Bundle|JSONObject|URLDecoder|ActivityResultLauncher|AppCompatActivity|ActionName|MiniAtmRequest)\b/g;
        const numberRegex = /\b\d+\b/g;
        const builtinRegex = /\b(super|this)\b/g;
        const tokenRegex = /("([^"\\]|\\.)*"|'([^'\\]|\\.)*'|\/\/.*?$)/gm;

        const escapeHtml = (text) => text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        const highlightPlain = (text) => {
            let html = escapeHtml(text);
            html = html.replace(numberRegex, '<span class="code-number">$&</span>');
            html = html.replace(keywordRegex, '<span class="code-keyword">$&</span>');
            html = html.replace(typeRegex, '<span class="code-type">$&</span>');
            html = html.replace(builtinRegex, '<span class="code-builtin">$&</span>');
            return html;
        };

        const highlightCode = (text) => {
            let result = '';
            let lastIndex = 0;
            text.replace(tokenRegex, (match, _p1, _p2, _p3, offset) => {
                result += highlightPlain(text.slice(lastIndex, offset));
                if (match.trim().startsWith('//')) {
                    result += `<span class="code-comment">${escapeHtml(match)}</span>`;
                } else {
                    result += `<span class="code-string">${escapeHtml(match)}</span>`;
                }
                lastIndex = offset + match.length;
                return match;
            });
            result += highlightPlain(text.slice(lastIndex));
            return result;
        };

        document.querySelectorAll('code.code-highlight').forEach((code) => {
            const raw = code.textContent || '';
            code.innerHTML = highlightCode(raw);
        });
    });
</script>
@endpush
