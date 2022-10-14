// import { useEffect } from 'react';
// import Authenticated from '@/Layouts/Authenticated';
// import Label from '@/Components/Label';
// import Input from '@/Components/Input';
// import InputError from '@/Components/InputError';
// import Button from '@/Components/Button';
// import Checkbox from '@/Components/Checkbox';
// import { Head, Link, useForm } from '@inertiajs/inertia-react';

export default function Create(props) {
  return (<h1>Create</h1>);
  // const { data, setData, post, errors, processing, reset } = useForm({
  //   name: '',
  //   username: '',
  //   email: '',
  //   password: '',
  //   password_confirmation: '',
  //   status: true
  // });

  // useEffect(() => {
  //   return () => {
  //     reset('password', 'password_confirmation');
  //   };
  // }, []);

  // const onHandleChange = (event) => {
  //   setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
  // };

  // const submit = (e) => {
  //   e.preventDefault();

  //   post(route('users.store'));
  // };

  // return (
  //   <Authenticated
  //     auth={props.auth}
  //     errors={props.errors}
  //     header={
  //       <h2 className="font-semibold text-xl text-gray-800 leading-tight">
  //         <Link className="underline" href={route('users.index')}>Users</Link> / Crear
  //       </h2>}
  //   >
  //     <Head title="Users" />

  //     <div className="py-12">
  //       <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
  //         <form onSubmit={submit}>
  //           <div>
  //             <Label forInput="name" value="Name" />

  //             <Input
  //               type="text"
  //               name="name"
  //               value={data.name}
  //               className="mt-1 block w-full"
  //               autoComplete="name"
  //               isFocused={true}
  //               handleChange={onHandleChange}
  //             />

  //             <InputError message={errors.name} className="mt-2" />
  //           </div>

  //           <div className="mt-4">
  //             <Label forInput="username" value="Username" />

  //             <Input
  //               type="text"
  //               name="username"
  //               value={data.username}
  //               className="mt-1 block w-full"
  //               handleChange={onHandleChange}
  //             />

  //             <InputError message={errors.username} className="mt-2" />
  //           </div>

  //           <div className="mt-4">
  //             <Label forInput="email" value="Email" />

  //             <Input
  //               type="email"
  //               name="email"
  //               value={data.email}
  //               className="mt-1 block w-full"
  //               handleChange={onHandleChange}
  //             />

  //             <InputError message={errors.email} className="mt-2" />
  //           </div>

  //           <div className="mt-4">
  //             <Label forInput="password" value="Password" />

  //             <Input
  //               type="password"
  //               name="password"
  //               value={data.password}
  //               className="mt-1 block w-full"
  //               handleChange={onHandleChange}
  //             />

  //             <InputError message={errors.password} className="mt-2" />
  //           </div>

  //           <div className="mt-4">
  //             <Label forInput="password_confirmation" value="Confirm Password" />

  //             <Input
  //               type="password"
  //               name="password_confirmation"
  //               value={data.password_confirmation}
  //               className="mt-1 block w-full"
  //               handleChange={onHandleChange}
  //             />

  //             <InputError message={errors.password_confirmation} className="mt-2" />
  //           </div>

  //           <div className="mt-4">
  //             <Label forInput="status" value="Status" />

  //             <Checkbox
  //               name="status"
  //               value={data.status}
  //               checked={data.status}
  //               handleChange={onHandleChange}
  //             />
  //           </div>

  //           <div className="flex items-center justify-end mt-4">
  //             <Button className="ml-4" processing={processing}>
  //               Crear
  //             </Button>
  //           </div>
  //         </form>
  //       </div >
  //     </div >
  //   </Authenticated >
  // );
}
