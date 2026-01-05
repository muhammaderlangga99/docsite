# URI Scheme Param

Berikut ini adalah URI Scheme untuk perintah permintaan payment request ke aplikasi Cashlez dari aplikasi merchant.

## Action Name

- Cek Saldo: `checkbalance`
- Transfer: `transfer`
- Tarik Tunai: `cashwithdrawal`

## Contoh membangun URI untuk pindah aplikasi (Java)

```java
public void attemptRequestNg(ActionName actionName) {
  Intent intent = new Intent();
  StringBuilder sbUri = new StringBuilder();
  sbUri.append("cashlez://miniatm");
  sbUri.append(ACTION_NAME);
  sbUri.append("?launcher=");
  sbUri.append(data.isLauncher());
  sbUri.append("&amount=");
  sbUri.append(data.getAmount());
  sbUri.append("&callback=");
  sbUri.append(data.getCallback());
  if (actionName.equals(ActionName.Action_Transfer)){
    sbUri.append("&beneBankCode=");
    sbUri.append(data.getBeneBankCode());
    sbUri.append("&beneAccountNo=");
    sbUri.append(data.getBeneAccountNo());
  }
  /* sample additional query string */
  sbUri.append("&customerRefNo=BL123456");
  sbUri.append("&csr=BL654321");
  String strUri = sbUri.toString();
  intent.setAction("android.intent.action.VIEW");
  intent.setData(Uri.parse(strUri));
  nextLauncher.launch(intent);
}
```

## Contoh request Jump App (Kotlin)

```kotlin
val btnCb: Button = findViewById(R.id.btnCb)
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
}
```

## Class JumApp.java

```java
public class JumApp {
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
        private ActivityResultLauncher<Intent> nextLauncher;

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
            sbUri.append("&amount=");
            sbUri.append(data.getAmount());
            sbUri.append("&callback=");
            sbUri.append(data.getCallback());
            if (actionName.equals(ActionName.Action_Transfer)){
                sbUri.append("&beneBankCode=");
                sbUri.append(data.getBeneBankCode());
                sbUri.append("&beneAccountNo=");
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
}
```

## Payment Callback

Callback dapat di-handle dengan cara berikut:

```java
public void initJumpApp(AppCompatActivity activity){
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
}
```

```kotlin
override fun onRawResult(result: Intent) {
    val rawResult = uriToHashMap(result.data)
    Log.i("TAG", "onRawResult: $rawResult")
    updateResult(rawResult.toString(), "onRawResult")
}
```

## Contoh lampiran log respon

Check balance:

```
onRawResult: {approvalCode=173787607993, maskedPan=4889********2538, typeSavings=Tabungan, traceNo=000693, type=balance, respCode=00, status=Success}
```

Transfer:

```
onRawResult: {receiverAccountName=IQBAL RIZKY RAMDHAN, approvalCode=173787618762, maskedPan=4889********2538, senderBankName=Bank Jago, typeSavings=Tabungan, traceNo=000848, receiverBankName=PT. BANK MANDIRI, TBK., senderAccountName=NOVILANTI NUR, type=transfer, respCode=00, receiverAccount=15500088992, status=Success}
```

Withdrawal:

```
onRawResult: {approvalCode=173787626225, maskedPan=4889********2538, senderBankName=Bank Jago, typeSavings=Tabungan, traceNo=000850, senderAccountName=TRI WALIANGGA, type=withdraw, respCode=00, status=Success}
```
