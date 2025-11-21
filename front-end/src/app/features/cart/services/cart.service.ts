import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../../../environments/environment';

export interface CartItemResponse {
  id: string;
  quantity: number;
  subtotal: number;
  product: {
    name: string;
    price: number;
    stock: number;
  };
}

@Injectable({
  providedIn: 'root',
})
export class CartService {
  private cartApi = environment.cartUrl;
  private cartItemsApi = environment.cartItemUrl;

  constructor(private http: HttpClient) {}

  getCartItems(userId: string) {
    return this.http.get<CartItemResponse[]>(`${this.cartApi}/cart/${userId}`);
  }

  createUserCart(userId: string) {
    return this.http.post<{ message: string }>(`${this.cartApi}/`, { userId });
  }

  updateCartItemQuantity(cartItemId: string, quantity: number) {
    return this.http.put<CartItemResponse>(`${this.cartItemsApi}/update`, { cartItemId, quantity });
  }

  removeCartItem(cartItemId: string) {
    return this.http.delete<{ cartItemId: string }>(`${this.cartItemsApi}?itemId=${cartItemId}`);
  }
}
