import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private http : HttpClient) { };
  createProduct($data : any){
    this.http.post("http://localhost/product_crud/server/products.php" , $data);
  }
  getProducts() : Observable<any>{
   return this.http.get("http://localhost/product_crud/server/products.php");
  }
  deleteProduct(id : number){
    return this.http.delete(`http://localhost/product_crud/server/products.php` , {
      params : {"id" : id}
    })
  }
  // updateProduct($id : number){
  //   this.http.put("http://localhost/product_crud/server/product.php" , )
  // }
  searchByname(keyword : string){
    this.http.get("http://localhost/product_crud/server/searchByname.php");
  }
  getProduct($id : number){
    this.http.get("http://localhost/product_crud/server/product.php")
  }
}