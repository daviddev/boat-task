import React from 'react';
import Box from '@mui/material/Box';
import CircularProgress from '@mui/material/CircularProgress';

const Preloader: React.FC = () => {
    return <Box className="preloader">
        <CircularProgress/>
    </Box>;
};

export default Preloader;
