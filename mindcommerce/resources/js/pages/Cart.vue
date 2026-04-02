<script setup lang="ts">
import { App, Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import ProductCart from '@/components/ProductCart.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import Button from '@/components/ui/button/Button.vue';

interface Product {

    id: number,
    name: string,
    SKU: string,
    categories: string,
    description: string,
    price: number,
    stock: number,
    qty: number
    ;
}

const props = defineProps({ products_in_cart: Array<Product> })

let prodotti = ref(props.products_in_cart)
let totale_ivato = ref(0)

calcola_totale()

function calcola_totale() {
    totale_ivato.value = prodotti.value?.reduce(
        (accumulator, product) => accumulator + (product.price * product.qty * 1.22),
        0,
    );
}

function deleteProduct(id: any) {
    console.log("elimino prodotto " + id)
    prodotti.value = prodotti.value.filter(prodotto => prodotto?.id != id)

    calcola_totale()

}
function ChangeProductQty(prod_id:any, new_qty:any) {
    console.log('modificata qty prodotto '+prod_id+' in '+new_qty)
    
    prodotti.value = prodotti.value.map(prodotto => {
        if(prodotto.id == prod_id){
            prodotto.qty=new_qty
        }
       return prodotto
    })

    calcola_totale()

}

function ProceedToCheckout(){
   
    let qty_checked = prodotti.value?.every((prodotto)=> prodotto.qty>0)

    if(qty_checked){
        router.get("/checkout")
    }else{
        alert("attenzione tutti i prodotti a carrello devono essere con quantità maggiore di zero")
    }

}

</script>

<template>

    <Head title="Cart" />


    <AppLayout :breadcrumbs="[]">
        <div class="flex flex-wrap overflow-auto">
            Prezzo Totale: {{ totale_ivato.toFixed(2) }} €
            <br/>
            <Button v-on:click="ProceedToCheckout"> Checkout </Button>
            <Separator></Separator>
            <ProductCart @delete-product="deleteProduct" @change-qty="ChangeProductQty" v-for="product in prodotti" :product="product">
            </ProductCart>
        </div>

    </AppLayout>
</template>
