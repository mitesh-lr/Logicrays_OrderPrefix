# About  Extension
This extension allows you to add your custome prefix at Order Id, Shipment Id, Invoice Id, and Creditmemo Id.

# Related GraphQL
* type StoreConfig

    type StoreConfig {
        order_prefix_enable : String @doc(description: "To fetch value of module enable or disable"),
        order_prefix_order_id_prefix : String @doc(description: "fetch value of order id prefix"),
        order_prefix_invoice_id_prefix : String @doc(description: "fetch value of invoice id prefix"),
        order_prefix_shipment_id_prefix : String @doc(description: "fetch value of shipment id prefix"),
        order_prefix_creditmemo_id_prefix : String @doc(description: "fetch value of creditmemo id prefix")
    }

-> This graphql returns all of the admin-side configuration values.

**Please Note.**


1. **order_prefix_enable**: In this field, you get an output of 1, and only then does this extension function in your store.

2. **order_prefix_order_id_prefix**: In this field, you get some text, so you have to set that text at your front-end side
    Order Id prefix wherever on your site order ids are available; you just need to add a prefix with order Id.
    For Example: Order is 0000052 and you will  get in this field text is OIRS then your Order is OIRS0000052.
