# Feature Request: Enable MiniATM Service on Dashboard

## 1. Overview
We need to add a new "Activate MiniATM Service" card in the **Dashboard Overview** menu (similar to existing service cards).

## 2. User Story
As a User, I want to click an activation button on the dashboard so that I can enable the MiniATM service for my account.

## 3. Technical Implementation

### Frontend (UI)
- Location: Dashboard > Overview.
- Element: A new Card titled "MiniATM Service".
- Action: Button "Activate Service".
- State: If already active, the button should be disabled or show "Active".

### Backend (Logic)
When the button is clicked, perform a database insertion with the following specifications:

**Target Database:**
- Scheme: `midware_mini_atm`
- Table: `user_detail`

**Input Data Specifications:**
1.  **`merchant_mid_id`**: Set value to `97` (Hardcoded).
2.  **`username`**: Use the currently logged-in user's username (Reference table: `mobile_app_users`).
3.  **`tid` (Terminal ID)**:
    - Logic: Auto-increment based on the last recorded TID in the database.
    - Algorithm: `Last_TID + 1`. (e.g., if last is `12345036`, new one is `12345037`).
4.  **Default/Static Values**: Use the specific hardcoded values provided in the sample query for config columns (JSONs, batch groups, etc.).

### SQL Query Construction
Generate an `INSERT` statement dynamically based on the logic above.

**Table Schema Reference (Source User):**
User exists in `mobile_app_users` (PK: `username`).

**Target Insert Query Pattern:**
```sql
INSERT INTO `midware_mini_atm`.`user_detail` (
    `merchant_mid_id`, 
    `batch_group`, 
    `transaction_channel_id`, 
    `username`, 
    `tid`, 
    `batch_num`, 
    `pin_block_mk`, 
    `pin_block_wk`, 
    `last_credit_debit_user_detail_update_timestamp`, 
    `need_tlmk_dwl_flag`, 
    `settlement_session_num`, 
    `additional_param`, 
    `additional_key`
) VALUES (
    97, -- Fixed as per requirement
    "AJ_MINI_ATM_SIMULATOR", 
    "AJ_MA_TRX_SIMULATOR", 
    ?, -- Dynamic: Current Username
    ?, -- Dynamic: Generated TID (Last TID + 1)
    1, 
    "CE262A3D735EA2FB2C6D1CDCB66131A2", 
    "CE262A3D735EA2FB2C6D1CDCB66131A2", 
    NOW(), -- Current Timestamp
    0, 
    0, 
    '{"hsm": "HSM_LAB", "mode_bytes": false}', 
    '{"zpkUnderZmk_kcv":"45C96D","tpkUnderTmk_kcv":"DBCDEE","pinBlockMk":"CE262A3D735EA2FB2C6D1CDCB66131A2","zpkUnderLmk":"266026AE7B2FF559252332B6916A40C3","zpkUnderZmk":"10B024162F83DBEA6E3E660EF2D99AE9","tpkUnderLmk":"EAEC1676AFEF934B7D9EBD4CA3511280","clearTpk":"CE262A3D735EA2FB2C6D1CDCB66131A2","pinBlockWk":"CE262A3D735EA2FB2C6D1CDCB66131A2","zpkUnderLmk_kcv":"45C96D","tpkUnderTmk":"FCCDDF348E531F6420AE0D33B53C2308"}'
);