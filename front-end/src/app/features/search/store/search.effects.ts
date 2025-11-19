import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import { catchError, map, mergeMap, of } from 'rxjs';
import { SearchService } from '../services/search.service';
import * as SearchActions from './search.actions';

@Injectable()
export class SearchEffects {
  loadSearchResults$: any;
  loadCategoryResults$: any;

  constructor(private actions$: Actions, private searchService: SearchService) {
    this.loadSearchResults$ = createEffect(() =>
      this.actions$.pipe(
        ofType(SearchActions.loadSearchResults),
        mergeMap(({ query }: { query: string }) =>
          this.searchService.getProductsBySearch(query).pipe(
            map((results: any) => SearchActions.loadSearchResultsSuccess({ results })),
            catchError((err) => of(SearchActions.loadSearchResultsFailure({ error: err.message })))
          )
        )
      )
    );
    this.loadCategoryResults$ = createEffect(() =>
      this.actions$.pipe(
        ofType(SearchActions.loadCategoryResults),
        mergeMap(({ category }: { category: string }) =>
          this.searchService.getProductsByCategory(category).pipe(
            map((results: any) => SearchActions.loadCategoryResultsSuccess({ results })),
            catchError((err) =>
              of(SearchActions.loadCategoryResultsFailure({ error: err.message }))
            )
          )
        )
      )
    );
  }
}
