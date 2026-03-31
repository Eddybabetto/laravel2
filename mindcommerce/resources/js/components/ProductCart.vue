<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import Button from '@/components/ui/button/Button.vue';
import { router } from '@inertiajs/vue3';
import { NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput, NumberFieldRoot } from 'reka-ui'
import { Minus, Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import Alert from './ui/alert/Alert.vue';

interface Props {
  product: {
    id: number,
    name: string,
    SKU: string,
    categories: string,
    description: string,
    price: number,
    stock: number,
    qty: number
  };
}

const props = defineProps<Props>();
const emit = defineEmits(['deleteProduct', "changeQty"])
async function RemoveFromCart() {

  try {
    const response = await fetch("/cart/remove/" + props.product.id, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" }
    })
    if (response.ok) {
      emit("deleteProduct", props.product.id)
    }
  } catch (error) {
    console.error(error.message);
  }

}

async function decrementQty() {

  try {
    const response = await fetch("/cart/edit/", {
      method: "POST",
      body: JSON.stringify({ "product_id": props.product.id, "qty": props.product.qty - 1 }),
      headers: { "Content-Type": "application/json" }
    })
    if (response.ok) {
      emit("changeQty", props.product.id, --props.product.qty)
    }
  } catch (error: any) {
    console.error(error.message);
  }

}
async function incrementQty() {

  try {
    const response = await fetch("/cart/edit/", {
      method: "POST",
      body: JSON.stringify({ "product_id": props.product.id, "qty": props.product.qty + 1 }),
      headers: { "Content-Type": "application/json" }
    })
    if (response.ok) {
      emit("changeQty", props.product.id, ++props.product.qty)
    }
  } catch (error: any) {
    console.error(error.message);
  }


}

</script>

<template>

  <br>
  <Card class="w-100 m-4" :class="{'border-red-100 dark:border-red-200/10 dark:bg-red-700/10 bg-red-50 text-red-600 dark:text-red-100': !!!product.qty }"> <!--- il triplo ! casta a booleano il valore (!! shorthand js per castare a bool) e poi lo nega (!) -->
    <CardHeader>
      <CardTitle>{{ product.name }}</CardTitle>
      <CardDescription>SKU: {{ product.SKU }}</CardDescription>
    </CardHeader>

    <CardContent>

      <CardDescription>Totale ivato prodotto: {{ (product.price * product.qty * 1.22).toFixed(2) }} €</CardDescription>
    </CardContent>
    <CardFooter>

      <NumberFieldRoot class="m-4" id="qty" :model-value="product.qty" :min="0" :max="product.stock" :default-value="1">
        <div
          class="mt-1 flex items-center border bg-white hover:bg-stone-50 rounded-lg shadow-sm h-9 focus-within:shadow-[0_0_0_2px] focus-within:shadow-stone-800">
          <NumberFieldDecrement v-on:click="decrementQty()" class="p-2 disabled:opacity-20">
            <Minus></Minus>
          </NumberFieldDecrement>
          <NumberFieldInput class="bg-transparent w-7 tabular-nums text-center focus:outline-0 p-1" />
          <NumberFieldIncrement v-on:click="incrementQty()" class="p-2 disabled:opacity-20">
            <Plus />
          </NumberFieldIncrement>
        </div>
      </NumberFieldRoot>

      <Button variant="destructive" v-on:click="RemoveFromCart()">RIMUOVI</Button>
      
    </CardFooter>
  </Card>

</template>
