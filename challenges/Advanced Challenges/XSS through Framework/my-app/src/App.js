import logo from './logo.svg';
import './App.css';
import React from "react";
import Swal from 'sweetalert2';

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      name: '',
      link: '',
      table_value: []
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleDelete = this.handleDelete.bind(this);
  }

  handleChange(event) {
    this.setState({ ...this.state, [event.target.name]: event.target.value });
  }

  handleSubmit(event) {
    let table = this.state.table_value
    table.push({ name: this.state.name, link: this.state.link })
    this.setState({ table_value: table })
    event.preventDefault();
  }

  handleDelete(name) {
    let table = this.state.table_value
    table = table.filter(function (obj) {
      return obj.name != name;
    })
    Swal.fire({
      title: "<small>Congratulation</small>!",
      text: "Hehe",
      html: "You have delete '" + name + "'!"
    });
    this.setState({ table_value: table })
  }

  render() {
    return (
      <div class="body">
        <form onSubmit={this.handleSubmit}>
          <div class="row g-2">
            <div class="col-md">
              <div class="form-floating mb-3">
                <input class="form-control" id="floatingInput" name="name" placeholder='Todo Work!' value={this.state.name} onChange={this.handleChange} />
                <label for="floatingInput">Todo Work!</label>
              </div>
            </div>

            <div class="col-md">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingPassword" name="link" placeholder='Link for Work' value={this.state.link} onChange={this.handleChange} />
                <label for="floatingPassword">Link for Work</label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary mb-3" value="submit" />
          </div>
          {/* <button onClick={this.handleSubmit}>Submit</button> */}
        </form>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Todo Work</th>
              <th scope="col">Link for Work</th>
              <th scope="col">Delete Button</th>
            </tr>
          </thead>
          {this.state.table_value.map((value) => {
            return (
              <tbody>
                <tr>
                  <th>{value.name}</th>
                  <th><a href={value.link}>{value.link}</a></th>
                  <th><button type="button" class="btn btn-outline-danger" onClick={() => this.handleDelete(value.name)}>Delete</button></th>
                </tr>
              </tbody>
            )
          })}
        </table>
      </div>
    );
  }
}

export default App;
