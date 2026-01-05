@extends('layout.dashboard')

@section('title', 'App2App CDCP & QRIS')

@section('dashboard-content')
@php
    $codeSnippet = <<<'CODE'
// Example for use Callback Intent

val openCdcpSale = Intent(Intent.ACTION_VIEW, "cashlez://cdcp?launcher=true&amount=1000&callback=app2://sale.result&pos_req_id=123456789&pos_invoice_no=123456".toUri())

startActivity(openCdcpSale)

// Example for use Activity Result

val openCdcpSale = Intent(Intent.ACTION_VIEW, "cashlez://cdcp?launcher=true&amount=1000&pos_req_id=123456789&pos_invoice_no=123456".toUri())

startActivityForResult(openCdcpSale, 211)
CODE;
    $resultSnippet = <<<'CODE'
override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
    super.onActivityResult(requestCode, resultCode, data)
    val string = StringBuilder()

    val status = data?.getStringExtra("status")
    val type = data?.getStringExtra("type")
    val dataString = data?.getStringExtra("data")

    if (status == "success" && !dataString.isNullOrEmpty()) {
        val jsonObject = JSONObject(dataString)
        val invoice = jsonObject.optString("invoice_num")

        // Handle success
        Toast.makeText(this, "Payment successful for invoice: $invoice", Toast.LENGTH_LONG).show()
    } else {
        // Handle other statuses
        Toast.makeText(this, "Transaction failed or cancelled", Toast.LENGTH_LONG).show()
    }

    string.append("from=onActivityResult\n")
    string.append("requestCode=$requestCode\n")
    string.append("resultCode=$resultCode\n")
    string.append("status=${status}\n")
    string.append("type=${type}\n")
    string.append("data=${dataString}\n")
    binding.tvResult.text = string

    Log.e("TAG", "$requestCode $resultCode ${data?.extras?.keySet()?.joinToString()}")
Log.e("TAG", string.toString())
}
CODE;
    $onCreateSnippet = <<<'CODE'
override fun onCreate(savedInstanceState: Bundle?) {
    super.onCreate(savedInstanceState)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        intent?.data?.let { uri ->
            Log.e("TAG", uri.toString())
            val status = uri.getQueryParameter("status")
            val type = uri.getQueryParameter("type")
            val data = uri.getQueryParameter("data")

            if (status == "success") {
                // Decode JSON data
                val decodedData = URLDecoder.decode(data, "UTF-8")
                val jsonObject = JSONObject(decodedData)
                val invoice = jsonObject.optString("invoice_num")
                // Handle success
                Toast.makeText(this, "Payment successful for invoice: $invoice", Toast.LENGTH_LONG).show()
            } else {
                // Handle other statuses
                Toast.makeText(this, "Transaction failed or cancelled", Toast.LENGTH_LONG).show()
            }
        }
    }
}
CODE;
@endphp
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">App2App</p>
        <h1 class="text-2xl font-semibold text-slate-900">CDCP &amp; QRIS</h1>
        <p class="text-sm text-slate-500 mt-1">Credential data for the signed-in user.</p>
    </div>
</div>

<div class="border border-slate-200 bg-white text-slate-900 rounded-xl p-6 text-sm shadow-sm space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.08em] text-emerald-600 mb-1">Credentials</p>
            <p class="font-semibold text-lg text-slate-900">Aktif</p>
        </div>
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Ready</span>
    </div>

    <div class="grid md:grid-cols-2 gap-3">
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Host</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $host }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $host }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Username</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $user?->username ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $user?->username }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Password</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $password }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $password }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Device ID / SN</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $user?->device_id ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $user?->device_id }}">Copy</button>
            </div>
        </div>
    </div>
</div>



<h4 class="font-semibold mt-6 text-zinc-800">The following is a code snippet used to execute the application switching command: </h4>
<div class="border mt-3 border-slate-200 rounded-xl p-6 bg-slate-900 text-slate-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between gap-2 mb-4">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
        </div>
        <button type="button" class="text-xs px-2 py-1 rounded border border-slate-700 text-slate-200 hover:bg-slate-800 transition copy-btn" data-copy="{{ $codeSnippet }}">Copy code</button>
    </div>
    <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code><span class="text-slate-300">// Example for use Callback Intent</span>

<span class="text-amber-300">val</span> <span class="text-sky-200">openCdcpSale</span> = <span class="text-orange-400">Intent</span>(<span class="text-orange-400">Intent.ACTION_VIEW</span>, <span class="text-emerald-300">"cashlez://cdcp?launcher=true&amp;amount=1000&amp;callback=app2://sale.result&amp;pos_req_id=123456789&amp;pos_invoice_no=123456"</span>.<span class="text-orange-400">toUri</span>())

<span class="text-orange-300">startActivity</span>(<span class="text-sky-200">openCdcpSale</span>)

<span class="text-slate-300">// Example for use Activity Result</span>

<span class="text-amber-300">val</span> <span class="text-sky-200">openCdcpSale</span> = <span class="text-orange-400">Intent</span>(<span class="text-orange-400">Intent.ACTION_VIEW</span>, <span class="text-emerald-300">"cashlez://cdcp?launcher=true&amp;amount=1000&amp;pos_req_id=123456789&amp;pos_invoice_no=123456"</span>.<span class="text-orange-400">toUri</span>())

<span class="text-orange-300">startActivityForResult</span>(<span class="text-sky-200">openCdcpSale</span>, <span class="text-lime-300">211</span>)
</code></pre>
</div>


<h4 class="font-semibold mt-8 text-zinc-800">The following is a code snippet for handling the callback from the Intent process via Activity Result: </h4>
<div class="border mt-3 border-slate-200 rounded-xl p-6 bg-slate-900 text-slate-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between gap-2 mb-4">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
        </div>
        <button type="button" class="text-xs px-2 py-1 rounded border border-slate-700 text-slate-200 hover:bg-slate-800 transition copy-btn" data-copy="{{ $resultSnippet }}">Copy code</button>
    </div>
    <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code><span class="text-amber-300">override</span> <span class="text-amber-300">fun</span> <span class="text-sky-200">onActivityResult</span>(<span class="text-orange-300">requestCode</span>: <span class="text-slate-200">Int</span>, <span class="text-orange-300">resultCode</span>: <span class="text-slate-200">Int</span>, <span class="text-orange-300">data</span>: <span class="text-slate-200">Intent</span>?) {
    <span class="text-orange-300">super</span>.<span class="text-sky-200">onActivityResult</span>(<span class="text-orange-300">requestCode</span>, <span class="text-orange-300">resultCode</span>, <span class="text-orange-300">data</span>)
    <span class="text-amber-300">val</span> <span class="text-sky-200">string</span> = <span class="text-orange-400">StringBuilder</span>()

    <span class="text-amber-300">val</span> <span class="text-sky-200">status</span> = <span class="text-orange-300">data</span>?.<span class="text-orange-300">getStringExtra</span>(<span class="text-emerald-300">"status"</span>)
    <span class="text-amber-300">val</span> <span class="text-sky-200">type</span> = <span class="text-orange-300">data</span>?.<span class="text-orange-300">getStringExtra</span>(<span class="text-emerald-300">"type"</span>)
    <span class="text-amber-300">val</span> <span class="text-sky-200">dataString</span> = <span class="text-orange-300">data</span>?.<span class="text-orange-300">getStringExtra</span>(<span class="text-emerald-300">"data"</span>)

    <span class="text-amber-300">if</span> (<span class="text-sky-200">status</span> == <span class="text-emerald-300">"success"</span> &amp;&amp; !<span class="text-sky-200">dataString</span>.<span class="text-orange-300">isNullOrEmpty</span>()) {
        <span class="text-amber-300">val</span> <span class="text-sky-200">jsonObject</span> = <span class="text-orange-400">JSONObject</span>(<span class="text-sky-200">dataString</span>)
        <span class="text-amber-300">val</span> <span class="text-sky-200">invoice</span> = <span class="text-sky-200">jsonObject</span>.<span class="text-orange-300">optString</span>(<span class="text-emerald-300">"invoice_num"</span>)

        <span class="text-slate-300">// Handle success</span>
        <span class="text-orange-300">Toast</span>.<span class="text-orange-300">makeText</span>(<span class="text-orange-300">this</span>, <span class="text-emerald-300">"Payment successful for invoice: $invoice"</span>, <span class="text-orange-300">Toast</span>.<span class="text-orange-300">LENGTH_LONG</span>).<span class="text-orange-300">show</span>()
    } <span class="text-amber-300">else</span> {
        <span class="text-slate-300">// Handle other statuses</span>
        <span class="text-orange-300">Toast</span>.<span class="text-orange-300">makeText</span>(<span class="text-orange-300">this</span>, <span class="text-emerald-300">"Transaction failed or cancelled"</span>, <span class="text-orange-300">Toast</span>.<span class="text-orange-300">LENGTH_LONG</span>).<span class="text-orange-300">show</span>()
    }

    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"from=onActivityResult\n"</span>)
    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"requestCode=$requestCode\n"</span>)
    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"resultCode=$resultCode\n"</span>)
    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"status=${status}\n"</span>)
    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"type=${type}\n"</span>)
    <span class="text-sky-200">string</span>.<span class="text-orange-300">append</span>(<span class="text-emerald-300">"data=${dataString}\n"</span>)
    <span class="text-sky-200">binding</span>.<span class="text-sky-200">tvResult</span>.<span class="text-orange-300">text</span> = <span class="text-sky-200">string</span>

    <span class="text-orange-300">Log</span>.<span class="text-orange-300">e</span>(<span class="text-emerald-300">"TAG"</span>, <span class="text-emerald-300">"$requestCode $resultCode ${data?.extras?.keySet()?.joinToString()}"</span>)
    <span class="text-orange-300">Log</span>.<span class="text-orange-300">e</span>(<span class="text-emerald-300">"TAG"</span>, <span class="text-sky-200">string</span>.<span class="text-orange-300">toString</span>())
}
</code></pre>
</div>


<h4 class="font-semibold mt-8 text-zinc-800">The following is a code snippet for handling the callback from the Intent process via Activity Result:</h4>
<div class="border mt-3 border-slate-200 rounded-xl p-6 bg-slate-900 text-slate-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between gap-2 mb-4">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
        </div>
        <button type="button" class="text-xs px-2 py-1 rounded border border-slate-700 text-slate-200 hover:bg-slate-800 transition copy-btn" data-copy="{{ $onCreateSnippet }}">Copy code</button>
    </div>
    <pre class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap break-all"><code><span class="text-amber-300">override</span> <span class="text-amber-300">fun</span> <span class="text-sky-200">onCreate</span>(<span class="text-orange-300">savedInstanceState</span>: <span class="text-slate-200">Bundle</span>?) {
    <span class="text-orange-300">super</span>.<span class="text-sky-200">onCreate</span>(<span class="text-orange-300">savedInstanceState</span>)

    <span class="text-amber-300">override</span> <span class="text-amber-300">fun</span> <span class="text-sky-200">onCreate</span>(<span class="text-orange-300">savedInstanceState</span>: <span class="text-slate-200">Bundle</span>?) {
        <span class="text-orange-300">super</span>.<span class="text-sky-200">onCreate</span>(<span class="text-orange-300">savedInstanceState</span>)

        <span class="text-sky-200">intent</span>?.<span class="text-sky-200">data</span>?.<span class="text-sky-200">let</span> { <span class="text-orange-300">uri</span> ->
            <span class="text-orange-300">Log</span>.<span class="text-orange-300">e</span>(<span class="text-emerald-300">"TAG"</span>, <span class="text-orange-300">uri</span>.<span class="text-sky-200">toString</span>())
            <span class="text-amber-300">val</span> <span class="text-sky-200">status</span> = <span class="text-orange-300">uri</span>.<span class="text-orange-300">getQueryParameter</span>(<span class="text-emerald-300">"status"</span>)
            <span class="text-amber-300">val</span> <span class="text-sky-200">type</span> = <span class="text-orange-300">uri</span>.<span class="text-orange-300">getQueryParameter</span>(<span class="text-emerald-300">"type"</span>)
            <span class="text-amber-300">val</span> <span class="text-sky-200">data</span> = <span class="text-orange-300">uri</span>.<span class="text-orange-300">getQueryParameter</span>(<span class="text-emerald-300">"data"</span>)

            <span class="text-amber-300">if</span> (<span class="text-sky-200">status</span> == <span class="text-emerald-300">"success"</span>) {
                <span class="text-slate-300">// Decode JSON data</span>
                <span class="text-amber-300">val</span> <span class="text-sky-200">decodedData</span> = <span class="text-orange-400">URLDecoder</span>.<span class="text-orange-300">decode</span>(<span class="text-sky-200">data</span>, <span class="text-emerald-300">"UTF-8"</span>)
                <span class="text-amber-300">val</span> <span class="text-sky-200">jsonObject</span> = <span class="text-orange-400">JSONObject</span>(<span class="text-sky-200">decodedData</span>)
                <span class="text-amber-300">val</span> <span class="text-sky-200">invoice</span> = <span class="text-sky-200">jsonObject</span>.<span class="text-orange-300">optString</span>(<span class="text-emerald-300">"invoice_num"</span>)
                <span class="text-slate-300">// Handle success</span>
                <span class="text-orange-300">Toast</span>.<span class="text-orange-300">makeText</span>(<span class="text-orange-300">this</span>, <span class="text-emerald-300">"Payment successful for invoice: $invoice"</span>, <span class="text-orange-300">Toast</span>.<span class="text-orange-300">LENGTH_LONG</span>).<span class="text-orange-300">show</span>()
            } <span class="text-amber-300">else</span> {
                <span class="text-slate-300">// Handle other statuses</span>
                <span class="text-orange-300">Toast</span>.<span class="text-orange-300">makeText</span>(<span class="text-orange-300">this</span>, <span class="text-emerald-300">"Transaction failed or cancelled"</span>, <span class="text-orange-300">Toast</span>.<span class="text-orange-300">LENGTH_LONG</span>).<span class="text-orange-300">show</span>()
            }
        }
    }
}
</code></pre>
</div>
@endsection

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
    });
</script>
@endpush
