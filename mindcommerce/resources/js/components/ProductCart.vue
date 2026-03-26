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

async function RemoveFromCart() {
  return true;
  await fetch("/cart/add", {
    method: "POST",
    body: JSON.stringify({ "product_id": props.product.id, "qty": this.qty }),
    headers: { "Content-Type": "application/json" }
  });
}

</script>

<template>

  <br>
  <Card class="w-100 m-4">
    <CardHeader>
      <CardTitle>{{ product.name }}</CardTitle>
      <CardDescription>{{ product.SKU }}</CardDescription>
      <CardDescription>categorie: {{ product.categories }}</CardDescription>
    </CardHeader>

    <CardContent>
      <CardDescription>{{ product.description }}</CardDescription>
      <CardDescription>{{ (product.price * 1.22).toFixed(2) }} €</CardDescription>
    </CardContent>
    <CardFooter>

      <NumberFieldRoot class="m-4" id="qty" v-model="product.qty" :min="0" :max="product.stock" :default-value="1">
        <div
          class="mt-1 flex items-center border bg-white hover:bg-stone-50 rounded-lg shadow-sm h-9 focus-within:shadow-[0_0_0_2px] focus-within:shadow-stone-800">
          <NumberFieldDecrement class="p-2 disabled:opacity-20">
            <Minus></Minus>
          </NumberFieldDecrement>
          <NumberFieldInput class="bg-transparent w-5 tabular-nums text-center focus:outline-0 p-1" />
          <NumberFieldIncrement class="p-2 disabled:opacity-20">
            <Plus />
          </NumberFieldIncrement>
        </div>
      </NumberFieldRoot>

      <Button variant="destructive"  v-on:click="removeFromCart()">RIMUOVI</Button>
      
    </CardFooter>
  </Card>

</template>
