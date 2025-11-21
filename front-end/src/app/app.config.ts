import { ApplicationConfig, provideBrowserGlobalErrorListeners, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
import { provideClientHydration, withEventReplay } from '@angular/platform-browser';
import { provideHttpClient, withFetch } from '@angular/common/http';
import { provideStore } from '@ngrx/store';
import { provideEffects } from '@ngrx/effects';
import { ProductsEffects } from './features/result/store/product.effects';
import { productReducer } from './features/result/store/product.reducers';
import { cartReducer } from './features/cart/store/cart.reducers';
import { CartEffects } from './features/cart/store/cart.effects';
import { orderReducer } from './features/order/store/order.reducers';
import { OrderEffects } from './features/order/store/order.effects';
import { SearchEffects } from './features/search/store/search.effects';
import { searchReducer } from './features/search/store/search.reducers';
import { AuthEffects } from './features/auth/store/auth.effects';
import { authReducer } from './features/auth/store/auth.reducers';

export const appConfig: ApplicationConfig = {
  providers: [
    provideHttpClient(withFetch()),
    provideBrowserGlobalErrorListeners(),
    provideZoneChangeDetection({ eventCoalescing: true }),
    provideRouter(routes), provideClientHydration(withEventReplay()),
    provideStore({products: productReducer, cart: cartReducer,orders: orderReducer, search: searchReducer, auth: authReducer}),
    provideEffects([ProductsEffects, CartEffects, OrderEffects, SearchEffects, AuthEffects])
]
};
