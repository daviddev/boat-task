import React, {useEffect, useState} from 'react';
import {fetchBoat} from "../api";
import Box from '@mui/material/Box';
import Modal from '@mui/material/Modal';
import Slide from '@mui/material/Slide';
import Button from "@mui/material/Button";
import Dialog from '@mui/material/Dialog';
import Preloader from "../components/Preloader";
import {Carousel} from 'react-responsive-carousel';
import {Container, TextField} from "@mui/material";
import DialogTitle from '@mui/material/DialogTitle';
import DialogActions from '@mui/material/DialogActions';
import {$DisplayMoney, $ValidateEmail} from "../helpers";
import {TransitionProps} from '@mui/material/transitions';
import "react-responsive-carousel/lib/styles/carousel.min.css";

const popup_style = {
    position: 'absolute' as 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 400,
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4
};

const Transition = React.forwardRef(function Transition(
    props: TransitionProps & { children: React.ReactElement<any, any>},
    ref: React.Ref<unknown>
) {
    return <Slide direction="up" ref={ref} {...props} />;
});

const Show = React.FC = ({id}) => {
    const params = new URLSearchParams(window.location.search);

    const [loading, setLoading] = useState(true);
    const [dialog, setDialog] = useState(false);
    const [popup, setPopup] = useState(false);
    const [email, setEmail] = useState('');
    const [boat, setBoat] = useState(null);

    useEffect(() => {
        if (params.get('payment-status') === 'done') {
            setDialog(true);
        }
    }, []);

    useEffect(() => {
        fetchBoat(id).then(boat => {
            setBoat(boat);
        }).finally(() => {
            setLoading(false);
        });
    }, []);

    const checkout = () => {
        window.location.href = `/charge-checkout/${boat.id}?email=${email}`;
    };

    return loading ? <Preloader/> : <main className="show-screen">
        <Dialog
            aria-describedby="alert-dialog-slide-description"
            onClose={() => setDialog(false)}
            TransitionComponent={Transition}
            open={dialog}
            keepMounted
        >
            <DialogTitle>Payment successfully done!</DialogTitle>
            <DialogActions>
                <Button onClick={() => setDialog(false)}>Close</Button>
            </DialogActions>
        </Dialog>
        <Modal
            open={popup}
            onClose={() => setPopup(false)}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={popup_style} className="checkout-popup">
                <TextField
                    onChange={(({target}) => setEmail(target.value))}
                    value={email}
                    id="outlined-basic"
                    variant="outlined"
                    label="Email"
                />
                <Button
                    disabled={!$ValidateEmail(email)}
                    variant="contained"
                    onClick={checkout}
                    color="success"
                >Checkout</Button>
            </Box>
        </Modal>
        <Container>
            <div className="top-title">
                {boat.model.name} | {boat.title}
            </div>
            <Carousel autoPlay={true} width="100%">
                {boat.images.map(image => {
                    return <div key={`image-${image.id}`}>
                        <img src={image.url} alt="image"/>
                    </div>
                })}
            </Carousel>
            <div className="boat-details">
                <p>
                    <span>Price</span>
                    <span>{$DisplayMoney(boat.price)}</span>
                </p>
                <p>
                    <span>Year</span>
                    <span>{boat.year}</span>
                </p>
                <p>
                    <span>Beam</span>
                    <span>{boat.beam}m</span>
                </p>
                <p>
                    <span>Length</span>
                    <span>{boat.length}m</span>
                </p>
                <p>
                    <span>Persons</span>
                    <span>{boat.persons}</span>
                </p>
                <p>
                    <span>Fuel Type</span>
                    <span>{boat.fuel_type}</span>
                </p>
                <p>
                    <span>Fuel Capacity (L)</span>
                    <span>{boat.fuel_capacity}</span>
                </p>
                <p>
                    <span>Condition</span>
                    <span className="capitalize">{boat.condition}</span>
                </p>
                <p>
                    <span>HP</span>
                    <span>{boat.horsepower}</span>
                </p>
                <p>
                    <span>No. of engines</span>
                    <span>{boat.number_of_engines}</span>
                </p>
            </div>
            <div className="boat-description">{boat.description}</div>
            <div className="boat-actions">
                <Button variant="contained" onClick={() => window.location.href = '/'}>Back</Button>
                <Button variant="contained" onClick={() => setPopup(true)} color="success">Buy</Button>
            </div>
        </Container>
    </main>
};

export default Show;
