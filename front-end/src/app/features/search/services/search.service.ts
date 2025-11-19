import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../../../environments/environment';
import { map } from 'rxjs/operators';

export interface ProductResponse {
  id: string;
  name: string;
  category: string;
  price: number;
  stock: number;
}

@Injectable({
  providedIn: 'root',
})
export class SearchService {
  private productApi = environment.productUrl;

  constructor(private http: HttpClient) {}

  getProductsByCategory(category: string) {
    return this.http
      .get<{ success: boolean; products: ProductResponse[] }>(
        `${this.productApi}/product/category?category=${category}`
      )
      .pipe(map((res) => res.products));
  }

  getProductsBySearch(query: string) {
    return this.http
      .get<{ success: boolean; products: ProductResponse[] }>(`${this.productApi}/product/name?search=${query}`)
      .pipe(map((response) => response.products));
  }
}
